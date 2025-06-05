<?php

namespace App\Http\Controllers;

use App\Models\Falla;
use App\Models\Lugar;
use App\Models\Material;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class FallaController extends Controller
{
    // Mostrar reportes de fallas por lugar
    public function index(Request $request)
    {
        $id_lugar = $request->input('id_lugar');
        $fallas = Falla::where('id_lugar', $id_lugar)->paginate(10);

        return response()->json(['data' => $fallas]);
    }

    // Registrar un nuevo reporte de falla, descontar existencia y guardar materiales del reporte
    public function store(Request $request)
    {
        // Validar todos los campos enviados desde el modal
        $request->validate([
            'id_lugar'         => 'required|exists:tb_lugares,id_lugar',
            'eco'              => 'nullable|string|max:50',
            'placas'           => 'nullable|string|max:50',
            'marca'            => 'nullable|string|max:50',
            'ano'              => 'nullable|string|max:4',  // Se guardará en la columna "anio"
            'km'               => 'nullable|string|max:20',
            'fecha'            => 'nullable|date',
            'nombre_conductor' => 'nullable|string|max:255',
            'descripcion'      => 'nullable|string',
            'observaciones'    => 'nullable|string',
            'autorizado_por'   => 'required|string|max:255',
            'reviso_por'       => 'nullable|string|max:255',
            'correo_destino'   => 'nullable|email',
            'materials'        => 'required|string'  // JSON de materiales
        ]);

        // Decodificar el JSON enviado en "materials" para trabajar con él
        $materials = json_decode($request->materials, true);
        if (!is_array($materials) || empty($materials)) {
            return response()->json(['message' => 'No se seleccionaron materiales válidos.'], 422);
        }

        $materialsString = '';
        $totalQuantity   = 0;

        // Iniciar transacción para asegurar integridad de la operación
        DB::beginTransaction();
        try {
            // Iterar cada material para actualizar existencias y preparar un resumen
            foreach ($materials as $mat) {
                if (!isset($mat['id']) || !isset($mat['descripcion']) || !isset($mat['cantidad'])) {
                    continue;
                }
                $quantityToDiscount = (int)$mat['cantidad'];
                $totalQuantity += $quantityToDiscount;
                $materialsString .= $mat['descripcion'] . " (Cant: " . $quantityToDiscount . "), ";

                // Buscar el material y descontar la existencia
                $materialRecord = Material::find($mat['id']);
                if ($materialRecord) {
                    if ($materialRecord->existencia < $quantityToDiscount) {
                        DB::rollBack();
                        return response()->json([
                            'message' => 'No hay existencia suficiente para el material: ' . $mat['descripcion']
                        ], 422);
                    }
                    $materialRecord->existencia -= $quantityToDiscount;
                    $materialRecord->save();
                }
            }
            // Quitar la última coma y espacio
            $materialsString = rtrim($materialsString, ', ');

            // Preparar los datos para crear el registro de falla
            $data = [
                'id_lugar'         => $request->id_lugar,
                'eco'              => $request->eco,
                'placas'           => $request->placas,
                'marca'            => $request->marca,
                'anio'             => $request->ano,          // Se guarda "ano" en la columna "anio"
                'km'               => $request->km,
                'fecha'            => $request->fecha,
                'nombre_conductor' => $request->nombre_conductor,
                'descripcion'      => $request->descripcion,
                'observaciones'    => $request->observaciones,
                'material'         => $materialsString,       // Resumen de materiales para referencia
                'cantidad'         => $totalQuantity,
                'autorizado_por'   => $request->autorizado_por,
                'reviso_por'       => $request->reviso_por,
                'correo_destino'   => $request->correo_destino,
                'materials'        => $request->materials     // Se almacena el JSON original para el PDF
            ];

            $falla = Falla::create($data);
            DB::commit();

            return response()->json(['message' => 'Reporte de falla registrado', 'data' => $falla], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al registrar el reporte: ' . $e->getMessage()], 500);
        }
    }

    // Generar PDF del reporte de falla utilizando la vista "reporte_fallo.blade.php"
    public function generarPDF($id)
    {
        $falla = Falla::with('lugar')->findOrFail($id);

        // Decodificar el listado de materiales (JSON almacenado en 'materials')
        $materials = json_decode($falla->materials, true);
        if (!is_array($materials)) {
            $materials = [];
        }

        $data = [
            'lugar'             => isset($falla->lugar->nombre) ? $falla->lugar->nombre : 'N/A',
            'eco'               => $falla->eco,
            'placas'            => $falla->placas,
            'marca'             => $falla->marca,
            'anio'              => $falla->anio,
            'km'                => $falla->km,
            'fecha'             => $falla->fecha,
            'nombre_conductor'  => $falla->nombre_conductor,
            'descripcion'       => $falla->descripcion,
            'observaciones'     => $falla->observaciones,
            'autorizado_por'    => $falla->autorizado_por,
            'reviso_por'        => $falla->reviso_por,
            'materials'         => $falla->materials   // Enviamos el JSON para luego decodificarlo en la vista
        ];

        $pdf = Pdf::loadView('reporte_fallo', compact('data'));
        return $pdf->stream('reporte-fallo.pdf');
    }

    // Enviar el reporte por correo con PDF adjunto
    public function enviarCorreo(Request $request, $id)
    {
        $falla = Falla::findOrFail($id);
        $request->validate([
            'correo_destino' => 'required|email'
        ]);

        $data = [
            'lugar'             => isset($falla->lugar->nombre) ? $falla->lugar->nombre : 'N/A',
            'eco'               => $falla->eco,
            'placas'            => $falla->placas,
            'marca'             => $falla->marca,
            'anio'              => $falla->anio,
            'km'                => $falla->km,
            'fecha'             => $falla->fecha,
            'nombre_conductor'  => $falla->nombre_conductor,
            'descripcion'       => $falla->descripcion,
            'observaciones'     => $falla->observaciones,
            'autorizado_por'    => $falla->autorizado_por,
            'reviso_por'        => $falla->reviso_por,
            'materials'         => $falla->materials
        ];

        $pdf = Pdf::loadView('reporte_fallo', compact('data'));
        $correo = $request->correo_destino;

        Mail::send([], [], function ($message) use ($pdf, $correo) {
            $message->to($correo)
                    ->subject('Reporte de Falla')
                    ->attachData($pdf->output(), "Reporte_Falla.pdf");
        });

        return response()->json(['message' => 'Reporte enviado correctamente']);
    }
}

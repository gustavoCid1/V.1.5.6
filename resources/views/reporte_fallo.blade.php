<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Reporte de Fallas y Uso de Materiales</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h1,
        h3 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        .firma {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <h1>Reporte de Fallas / Uso de Materiales</h1>

    <table>
        <tr>
            <th>Lugar</th>
            <td>{{ $data['lugar'] }}</td>
        </tr>
        <tr>
            <th>No. ECO</th>
            <td>{{ $data['eco'] }}</td>
        </tr>
        <tr>
            <th>Placas</th>
            <td>{{ $data['placas'] }}</td>
        </tr>
        <tr>
            <th>Marca</th>
            <td>{{ $data['marca'] }}</td>
        </tr>
        <tr>
            <th>Año</th>
            <td>{{ $data['anio'] }}</td>
        </tr>
        <tr>
            <th>KM</th>
            <td>{{ $data['km'] }}</td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td>{{ $data['fecha'] }}</td>
        </tr>
        <tr>
            <th>Nombre del Conductor</th>
            <td>{{ $data['nombre_conductor'] }}</td>
        </tr>
    </table>

    <h3>Descripción del Servicio / Fallo</h3>
    <p>{{ $data['descripcion'] }}</p>

    <h3>Observaciones Técnicas del Trabajo Realizado</h3>
    <p>{{ $data['observaciones'] }}</p>

    <h3>Materiales Utilizados</h3>
    @php
        // Decodificamos el JSON que se almacenó en "materials"
        $materials = json_decode($data['materials'], true);
      @endphp
    @if(is_array($materials) && count($materials) > 0)
        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                    <tr>
                        <td>{{ $material['descripcion'] }}</td>
                        <td>{{ $material['cantidad'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No se registraron materiales</p>
    @endif

    <div class="firma">
        <p><strong>Autorizado por:</strong> {{ $data['autorizado_por'] }}</p>
        <p><strong>Revisado por:</strong> {{ $data['reviso_por'] }}</p>
    </div>
</body>

</html>
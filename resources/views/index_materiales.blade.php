<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Lista de Materiales - FontTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* MOD: Íconos y tipografía */
    .fa, .icon {
        font-size: 0.8em;
    }
    body {
        font-size: 0.9em;
    }
    h2 {
        font-size: 1.8em; /* antes 2em */
    }
    .navbar .navbar-brand {
        font-size: 1.4em; /* antes 1.6em */
    }
    .navbar .navbar-nav .nav-link {
        font-size: 0.9em; /* antes 1em */
    }
    .btn {
        font-size: 1em; /* antes 1.2em */
    }
    .search-input {
        font-size: 14px; /* antes 16px */
    }
    .table {
        font-size: 0.9em; /* texto de celdas */
    }

    /* Animaciones para modales - Efecto globo/agua */
    @keyframes modalBubbleIn {
        0% { transform: scale(0.3) translateY(100px); opacity: 0; }
        50% { transform: scale(1.05) translateY(-10px); opacity: 0.8; }
        70% { transform: scale(0.95) translateY(5px); opacity: 0.9; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
    }

    @keyframes modalWaterDropIn {
        0% { transform: scale(0) rotate(0deg); opacity: 0; filter: blur(10px); }
        30% { transform: scale(0.7) rotate(180deg); opacity: 0.7; filter: blur(5px); }
        60% { transform: scale(1.1) rotate(270deg); opacity: 0.9; filter: blur(2px); }
        100% { transform: scale(1) rotate(360deg); opacity: 1; filter: blur(0px); }
    }

    @keyframes modalFadeOut {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(0.8); opacity: 0; }
    }

    .modal.show .modal-dialog {
        animation: modalBubbleIn 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .modal-content {
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal.fade .modal-dialog {
        transition: all 0.4s ease-out;
    }

    .modal-backdrop {
        background: linear-gradient(45deg, rgba(0,0,0,0.5), rgba(0,0,0,0.7));
        backdrop-filter: blur(3px);
    }

    .navbar {
        background-color: #F6B88F;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        padding: 12px 20px;
        border-bottom: 4px solid #E38B5B;
    }

    .navbar .logo {
        cursor: pointer;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .navbar .logo:hover {
        transform: scale(1.05);
        filter: brightness(1.1);
    }

    .navbar .navbar-brand {
        color: #634D3B;
        font-weight: bold;
        transition: color 0.3s ease-in-out;
    }

    .navbar .navbar-brand:hover {
        color: #E38B5B;
    }

    .navbar .navbar-nav .nav-link {
        color: #634D3B;
        padding: 10px 15px;
        font-weight: bold;
        transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
    }

    .navbar .navbar-nav .nav-link:hover {
        background-color: rgba(227, 139, 91, 0.2);
        border-radius: 6px;
        transform: scale(1.05);
    }

    .navbar .btn-danger {
        background-color: #D9534F;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 6px;
        transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
    }

    .navbar .btn-danger:hover {
        background-color: #C9302C;
        transform: scale(1.1);
    }

    .navbar-toggler-icon {
        filter: invert(50%);
    }

    @media (max-width: 768px) {
        .navbar {
            padding: 8px 15px;
        }

        .navbar .navbar-brand {
            font-size: 1.3em;
        }

        .navbar .navbar-nav .nav-link {
            font-size: 0.9em;
            padding: 8px 10px;
        }
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #FCE8D5;
        color: #634D3B;
        text-align: center;
        margin: 0;
        padding: 0;
    }

    .container {
        background: #FFF;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
        color: #E38B5B;
        font-weight: bold;
    }

    .search-input {
        border: none;
        border-radius: 25px;
        padding: 12px 20px;
        box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .search-input:focus {
        transform: scale(1.02);
        box-shadow: 0 0 20px rgba(227, 139, 91, 0.5);
        outline: none;
    }

    .btn {
        background-color: #E38B5B;
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
        border-radius: 8px;
        padding: 12px 24px;
    }

    .btn:hover {
        background-color: #D1784C;
        transform: scale(1.05);
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead {
        background-color: #F6B88F;
        color: #fff;
    }

    .table th,
    .table td {
        padding: 15px;
    }

    .modal-header {
        background-color: #F6B88F;
        color: #fff;
    }

    .modal-footer {
        background-color: #FCE8D5;
    }

    .btn-info {
        background-color: #88C0D0;
        border: none;
    }

    .btn-warning {
        background-color: #E5A34D;
        border: none;
    }

    .btn-danger {
        background-color: #D9534F;
        border: none;
    }

    .pagination {
        display: flex;
        justify-content: center;
        padding: 20px;
        list-style: none;
        margin: 0;
    }

    .pagination li {
        margin: 0 3px;
    }

    .pagination li a,
    .pagination li span {
        text-decoration: none;
        padding: 12px 16px;
        background-color: #E38B5B;
        color: white;
        border-radius: 8px;
        font-weight: bold;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .pagination li a:hover {
        background-color: #D1784C;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(227, 139, 91, 0.4);
    }

    .pagination .active span {
        background-color: #F6B88F;
        color: #fff;
        border: 2px solid #E38B5B;
        transform: scale(1.1);
    }

    .pagination .disabled span {
        background-color: #ccc;
        color: #666;
        cursor: not-allowed;
    }

    .image-preview {
        max-width: 150px;
        max-height: 150px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease;
    }

    .image-preview:hover {
        transform: scale(1.05);
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(246, 184, 143, 0.1);
        transform: scale(1.01);
    }


            /* Estilo para el perfil de usuario */
        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid #E38B5B;
        }

        .user-profile .user-name {
            font-weight: bold;
            color: #634D3B;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 10px 0;
            min-width: 180px;
            z-index: 1000;
            display: none;
        }

        .user-dropdown.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .user-dropdown a {
            display: block;
            padding: 8px 15px;
            color: #634D3B;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .user-dropdown a:hover {
            background-color: rgba(227, 139, 91, 0.1);
            color: #E38B5B;
        }

        .user-dropdown a i {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 8px 15px;
            }

            .navbar .navbar-brand {
                font-size: 1.3em;
            }

            .navbar .navbar-nav .nav-link {
                font-size: 0.9em;
                padding: 8px 10px;
            }
            
            .user-profile {
                margin-top: 10px;
            }
            
            .user-dropdown {
                position: static;
                margin-top: 5px;
            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #FCE8D5;
            color: #634D3B;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #FFF;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #E38B5B;
            font-size: 2em;
            font-weight: bold;
        }

        /* Buscador de usuarios */
        .search-container {
            background: linear-gradient(135deg, #F6B88F, #E38B5B);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .search-input {
            border: none;
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 16px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .search-input:focus {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(227, 139, 91, 0.5);
            outline: none;
        }

        .btn {
            background-color: #E38B5B;
            color: #fff;
            font-size: 1.2em;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn:hover {
            background-color: #D1784C;
            transform: scale(1.05);
        }

        /* Estilo para botones de modales */
        .modal .btn {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
                .modal .btn:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .modal .btn:focus:after,
        .modal .btn:hover:after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(20, 20);
                opacity: 0;
            }
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background-color: #F6B88F;
            color: #fff;
        }

        .table th,
        .table td {
            padding: 15px;
        }

        .modal-header {
            background-color: #F6B88F;
            color: #fff;
        }

        .modal-footer {
            background-color: #FCE8D5;
        }

        .btn-info {
            background-color: #88C0D0;
            border: none;
        }

        .btn-warning {
            background-color: #E5A34D;
            border: none;
        }

        .btn-danger {
            background-color: #D9534F;
            border: none;
        }

        /* Paginación mejorada */
        .pagination {
            display: flex;
            justify-content: center;
            padding: 20px;
            list-style: none;
            margin: 0;
        }

        .pagination li {
            margin: 0 3px;
        }

        .pagination li a,
        .pagination li span {
            text-decoration: none;
            padding: 12px 16px;
            background-color: #E38B5B;
            color: white;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .pagination li a:hover {
            background-color: #D1784C;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(227, 139, 91, 0.4);
        }

        .pagination .active span {
            background-color: #F6B88F;
            color: #fff;
            border: 2px solid #E38B5B;
            transform: scale(1.1);
        }

        .pagination .disabled span {
            background-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }

</style>



</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <img src="{{ asset('img/FontTrack.png') }}" alt="logo" height="70px" width="100px" class="logo" onclick="window.location.href='{{ route('users') }}'">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('users') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('lugares.index') }}">Lugares</a>
                    </li>
                </ul>
                
                <!-- Perfil de usuario -->
                <div class="user-profile ms-auto">
                    <img src="{{ Auth::user()->foto_usuario_url ?? asset('img/usuario_default.png') }}" alt="Foto de perfil">
                    <span class="user-name">{{ Auth::user()->nombre }}</span>
                    <div class="user-dropdown">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Modal para subir archivos del Cardex -->
    <div class="modal fade" id="modalCardex" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formCardex" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">¿Archivos del Kardex?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_lugar" class="form-label">Selecciona el Lugar:</label>
                            <select id="id_lugar" name="id_lugar" class="form-select" required>
                                <option value="">-- Selecciona un lugar --</option>
                                @foreach($lugares as $lugar)
                                    <option value="{{ $lugar->id_lugar }}">{{ $lugar->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="archivo_cardex" class="form-label">Seleccionar Archivo Excel:</label>
                            <input type="file" id="archivo_cardex" name="archivo_cardex" class="form-control"
                                accept=".xlsx,.xls" required>
                            <div class="form-text">
                                El archivo debe contener: Clave Material, Descripción, Genérico, Clasificación,
                                Existencia, Costo Promedio.
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <strong>Formato requerido:</strong>
                            <ul class="mb-0">
                                <li>Clave Material</li>
                                <li>Descripción</li>
                                <li>Genérico</li>
                                <li>Clasificación</li>
                                <li>Existencia</li>
                                <li>Costo Promedio</li>
                            </ul>
                        </div>
                        <div id="progreso" class="mb-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted">Procesando archivo...</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnSubirCardex">Subir Archivo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Contenido principal de Materiales -->
    <div class="container mt-4">
        <h2 class="mb-3">Lista de Materiales</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex gap-2">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCardex">
                    📁 Subir Kardex
                </button>
                <button class="btn btn-warning" id="btnReporteFallas">
                    📋 Reporte de Fallas
                </button>
            </div>
            <form class="d-flex" action="{{ route('materials') }}" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Buscar material"
                    aria-label="Buscar" value="{{ request('query') }}">
                <button class="btn btn-outline-success me-2" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro"
                id="btnNuevoMaterial">
                Registrar Material
            </button>
        </div>
        <div class="table-responsive">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Clave</th>
                        <th>Descripción</th>
                        <th>Genérico</th>
                        <th>Clasificación</th>
                        <th>Existencia</th>
                        <th>Costo ($)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materiales as $material)
                        <tr data-id="{{ $material->id_material }}">
                            <td>{{ $material->id_material }}</td>
                            <td>{{ $material->clave_material }}</td>
                            <td>{{ $material->descripcion }}</td>
                            <td>{{ $material->generico }}</td>
                            <td>{{ $material->clasificacion }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <button class="btn btn-sm btn-success btnAumentar"
                                        data-id="{{ $material->id_material }}" title="Aumentar existencia">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                    <span class="mx-2">{{ $material->existencia }}</span>
                                    <button class="btn btn-sm btn-danger btnDisminuir"
                                        data-id="{{ $material->id_material }}" title="Reportar falla">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                </div>
                            </td>
                            <td>{{ $material->costo_promedio }}</td>
                            <td class="d-flex flex-column flex-md-row">
                                <button class="btn btn-info btnVer" data-id="{{ $material->id_material }}"
                                    data-bs-toggle="modal" data-bs-target="#modalVer">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-warning btnEditar" data-id="{{ $material->id_material }}"
                                    data-bs-toggle="modal" data-bs-target="#modalRegistro">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btnEliminar" data-id="{{ $material->id_material }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-center">
            {{ $materiales->appends(['query' => request('query')])->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <!-- Modal Registro/Edición Material -->
    <div class="modal fade" id="modalRegistro" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formRegistro">
                    @csrf
                    <input type="hidden" id="materialId">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar / Editar Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label for="clave_material">Clave:</label>
                        <input type="text" id="clave" name="clave_material" class="form-control" required>
                        <label for="descripcion">Descripción:</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control" required>
                        <label for="generico">Genérico:</label>
                        <input type="text" id="generico" name="generico" class="form-control" required>
                        <label for="clasificacion">Clasificación:</label>
                        <input type="text" id="clasificacion" name="clasificacion" class="form-control" required>
                        <label for="existencia">Existencia:</label>
                        <input type="text" id="existencia" name="existencia" class="form-control" readonly
                            style="background-color: #f8f9fa;">
                        <small class="text-muted">La existencia se modifica con los botones + y - en la tabla</small>
                        <label for="costo_promedio">Costo ($):</label>
                        <input type="text" id="costo" name="costo_promedio" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btnGuardarMaterial">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ver Material -->
    <div class="modal fade" id="modalVer" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Clave:</strong> <span id="verClave"></span></p>
                    <p><strong>Descripción:</strong> <span id="verDescripcion"></span></p>
                    <p><strong>Genérico:</strong> <span id="verGenerico"></span></p>
                    <p><strong>Clasificación:</strong> <span id="verClasificacion"></span></p>
                    <p><strong>Existencia:</strong> <span id="verExistencia"></span></p>
                    <p><strong>Costo ($):</strong> <span id="verCosto"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmación de Eliminación -->
    <div class="modal fade" id="modalEliminar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este material?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Aumentar Existencia -->
    <div class="modal fade" id="modalAumentar" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="formAumentar">
                    @csrf
                    <input type="hidden" id="materialIdAumentar">
                    <div class="modal-header">
                        <h5 class="modal-title">Aumentar Existencia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Material:</strong> <span id="materialNombreAumentar"></span></p>
                        <p><strong>Existencia actual:</strong> <span id="existenciaActualAumentar"></span></p>
                        <label for="cantidadAumentar">Cantidad a aumentar:</label>
                        <input type="number" id="cantidadAumentar" name="cantidad" class="form-control" min="1"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Aumentar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Reporte de Fallas / Uso de Materiales -->
    <div class="modal fade" id="modalFalla" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formFalla">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">REPORTE DE FALLAS / USO DE MATERIALES</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Selector de Lugar -->
                        <div class="mb-3">
                            <label for="id_lugar_falla" class="form-label">Selecciona el Lugar:</label>
                            <select id="id_lugar_falla" name="id_lugar" class="form-select" required>
                                <option value="">-- Selecciona un lugar --</option>
                                @foreach($lugares as $lugar)
                                    <option value="{{ $lugar->id_lugar }}">{{ $lugar->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Datos generales del vehículo/falla -->
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <label>No. ECO</label>
                                <input type="text" name="eco" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Placas</label>
                                <input type="text" name="placas" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Marca</label>
                                <input type="text" name="marca" class="form-control">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Año</label>
                                <input type="text" name="ano" class="form-control">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>KM</label>
                                <input type="text" name="km" class="form-control">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label>Fecha</label>
                                <input type="date" name="fecha" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Nombre del Conductor</label>
                            <input type="text" name="nombre_conductor" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Descripción Servicio / Fallo</label>
                            <textarea name="descripcion" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Observaciones Técnicas del Trabajo Realizado</label>
                            <textarea name="observaciones" rows="3" class="form-control"></textarea>
                        </div>
                        <!-- Sección de Materiales a Utilizar -->
                        <h6 class="mt-3">Materiales a utilizar</h6>
                        <div class="mb-3">
                            <label for="materialBuscar">Buscar Material</label>
                            <input type="text" id="materialBuscar" class="form-control" list="materialesList"
                                placeholder="Ingrese clave o descripción">
                            <datalist id="materialesList">
                                @foreach($materiales as $material)
                                    <option data-id="{{ $material->id_material }}"
                                        value="{{ $material->clave_material }} - {{ $material->descripcion }}"></option>
                                @endforeach
                            </datalist>
                            <button type="button" id="btnAgregarMaterial" class="btn btn-secondary mt-2">Agregar
                                Material</button>
                        </div>
                        <!-- Listado dinámico de Materiales seleccionados -->
                        <div class="table-responsive">
                            <table class="table table-sm" id="selectedMaterialsTable">
                                <thead>
                                    <tr>
                                        <th>Material</th>
                                        <th>Cantidad</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- Datos de Autorización -->
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label>Nombre y firma de quien reporta</label>
                                <input type="text" name="autorizado_por" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Nombre y firma de quien revisó</label>
                                <input type="text" name="reviso_por" class="form-control">
                            </div>
                        </div>
                        <div class="mb-2">
                            <label>Correo para enviar reporte</label>
                            <input type="email" name="correo_destino" class="form-control"
                                placeholder="correo@ejemplo.com">
                        </div>
                        <!-- Campo oculto para almacenar materiales en formato JSON -->
                        <input type="hidden" name="materials" id="materialsData">
                    </div>
                    <div class="modal-footer">
                        <!-- Botón para ver PDF previo -->
                        <button type="button" id="btnVerPDF" class="btn btn-info">Ver PDF</button>
                        <button type="submit" class="btn btn-primary">Guardar y enviar PDF</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para visualizar el PDF generado -->
    <div class="modal fade" id="modalVerPDF" tabindex="-1">
        <div class="modal-dialog modal-lg" style="max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vista Previa del PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="height: 80vh;">
                    <iframe id="iframePDF" src="" frameborder="0" style="width: 100%; height: 100%;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        $(document).ready(function () {
            // Función para agregar material a la tabla de selección
            function agregarMaterial(materialInfo) {
                let existe = false;
                $("#selectedMaterialsTable tbody tr").each(function () {
                    let id = $(this).data('id');
                    if (id == materialInfo.id) {
                        let cantidadInput = $(this).find('input.cantidad');
                        cantidadInput.val(parseInt(cantidadInput.val()) + 1);
                        existe = true;
                    }
                });
                if (!existe) {
                    let fila = `<tr data-id="${materialInfo.id}">
                        <td>${materialInfo.descripcion}</td>
                        <td><input type="number" class="form-control cantidad" value="1" min="1" style="width:80px"></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-success btnInc">+</button>
                          <button type="button" class="btn btn-sm btn-danger btnDec">-</button>
                          <button type="button" class="btn btn-sm btn-secondary btnRemove">X</button>
                        </td>
                      </tr>`;
                    $("#selectedMaterialsTable tbody").append(fila);
                }
                actualizarMaterialsData();
            }

            function actualizarMaterialsData() {
                let materiales = [];
                $("#selectedMaterialsTable tbody tr").each(function () {
                    let id = $(this).data('id');
                    let descripcion = $(this).find('td:first').text();
                    let cantidad = $(this).find('input.cantidad').val();
                    materiales.push({ id: id, descripcion: descripcion, cantidad: cantidad });
                });
                $('#materialsData').val(JSON.stringify(materiales));
            }

            // Eventos para incrementar, decrementar o remover material
            $("#selectedMaterialsTable").on("click", ".btnInc", function () {
                let input = $(this).closest('tr').find('input.cantidad');
                input.val(parseInt(input.val()) + 1);
                actualizarMaterialsData();
            });
            $("#selectedMaterialsTable").on("click", ".btnDec", function () {
                let input = $(this).closest('tr').find('input.cantidad');
                if (parseInt(input.val()) > 1) {
                    input.val(parseInt(input.val()) - 1);
                    actualizarMaterialsData();
                }
            });
            $("#selectedMaterialsTable").on("click", ".btnRemove", function () {
                $(this).closest('tr').remove();
                actualizarMaterialsData();
            });

            // Agregar material desde el buscador
            $("#btnAgregarMaterial").click(function () {
                let valor = $("#materialBuscar").val().trim();
                if (valor === "") {
                    alert("Por favor, ingrese el nombre o clave del material");
                    return;
                }
                let option = $('#materialesList option').filter(function () {
                    return $(this).val() === valor;
                }).first();
                if (option.length) {
                    let id = option.data('id');
                    let descripcion = option.val();
                    agregarMaterial({ id: id, descripcion: descripcion });
                    $("#materialBuscar").val("");
                } else {
                    alert("Material no encontrado en la lista");
                }
            });

            // Apertura del modal de fallas (desde botón Reporte o botón de “Disminuir” en la tabla)
            $('.btnDisminuir, #btnReporteFallas').click(function () {
                if ($(this).hasClass('btnDisminuir')) {
                    let fila = $(this).closest('tr');
                    let materialId = $(this).data('id');
                    let materialDescripcion = fila.find('td:nth-child(3)').text();
                    $("#selectedMaterialsTable tbody").html("");
                    agregarMaterial({ id: materialId, descripcion: materialDescripcion });
                } else {
                    $("#selectedMaterialsTable tbody").html("");
                    actualizarMaterialsData();
                }
                $("#modalFalla").modal("show");
            });

            // Envío del formulario de fallas
            $('#formFalla').submit(function (e) {
                e.preventDefault();
                actualizarMaterialsData();
                const formData = $(this).serialize();
                $.post('/fallas', formData, function (response) {
                    alert(response.message);
                    const correo = $('[name="correo_destino"]').val();
                    if (correo) {
                        $.post(`/fallas/enviar/${response.data.id}`, {
                            correo_destino: correo,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        })
                            .done(() => alert("Correo enviado"))
                            .fail(() => alert("Error al enviar correo"));
                    }
                    $('#modalFalla').modal('hide');
                    location.reload();
                }).fail(function (xhr) {
                    alert("Error al guardar: " + xhr.responseText);
                });
            });

            // Botón "Ver PDF" en el modal de fallas
            $("#btnVerPDF").click(function () {
                actualizarMaterialsData();
                let formData = $("#formFalla").serialize();
                $.post('/fallas', formData, function (response) {
                    $("#iframePDF").attr("src", "/fallas/pdf/" + response.data.id);
                    $("#modalVerPDF").modal("show");
                }).fail(function (xhr) {
                    alert("Error al generar PDF: " + xhr.responseText);
                });
            });

            // Formularios y acciones para materiales (edición, ver, eliminar y aumentar existencia)
            $('#formRegistro').submit(function (event) {
                event.preventDefault();
                let id = $('#materialId').val();
                let formData = $(this).serialize();
                if (id) {
                    let datos = $(this).serializeArray();
                    datos = datos.filter(item => item.name !== 'existencia');
                    formData = $.param(datos);
                }
                let url = id ? `/update_material/${id}` : `/register_material`;
                let method = id ? 'PUT' : 'POST';
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        const res = xhr.responseJSON;
                        if (res?.errors) {
                            let errores = Object.values(res.errors).flat().join('\n');
                            alert('Errores:\n' + errores);
                        } else {
                            alert('Error: ' + xhr.responseText);
                        }
                    }
                });
            });

            $('.btnEditar').click(function () {
                let id = $(this).data('id');
                $.get(`/edit_material/${id}`, function (response) {
                    let data = response.data;
                    $('#materialId').val(data.id_material);
                    $('#clave').val(data.clave_material);
                    $('#descripcion').val(data.descripcion);
                    $('#generico').val(data.generico);
                    $('#clasificacion').val(data.clasificacion);
                    $('#existencia').val(data.existencia).prop('readonly', true).css('background-color', '#f8f9fa');
                    $('#costo').val(data.costo_promedio);
                    $('#modalRegistro').modal('show');
                });
            });

            $('.btnVer').click(function () {
                let id = $(this).data('id');
                $.get(`/materials/${id}`, function (response) {
                    let data = response.data;
                    $('#verClave').text(data.clave_material);
                    $('#verDescripcion').text(data.descripcion);
                    $('#verGenerico').text(data.generico);
                    $('#verClasificacion').text(data.clasificacion);
                    $('#verExistencia').text(data.existencia);
                    $('#verCosto').text(data.costo_promedio);
                    $('#modalVer').modal('show');
                });
            });

            $('.btnEliminar').click(function () {
                let id = $(this).data('id');
                if (confirm('¿Seguro que quieres eliminar este material?')) {
                    $.ajax({
                        url: `/delete_material/${id}`,
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function (response) {
                            alert(response.message);
                            $(`tr[data-id="${id}"]`).remove();
                        },
                        error: function (xhr) {
                            alert('Error al eliminar material: ' + xhr.responseText);
                        }
                    });
                }
            });

            $('.btnAumentar').click(function () {
                let id = $(this).data('id');
                let fila = $(this).closest('tr');
                let descripcion = fila.find('td:nth-child(3)').text();
                let existenciaActual = fila.find('td:nth-child(6) span').text();
                $('#materialIdAumentar').val(id);
                $('#materialNombreAumentar').text(descripcion);
                $('#existenciaActualAumentar').text(existenciaActual);
                $('#cantidadAumentar').val('');
                $('#modalAumentar').modal('show');
            });

            $('#formAumentar').submit(function (event) {
                event.preventDefault();
                let id = $('#materialIdAumentar').val();
                let cantidad = $('#cantidadAumentar').val();
                $.ajax({
                    url: `/materials/${id}/aumentar`,
                    type: 'POST',
                    data: {
                        cantidad: cantidad,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert('Error al aumentar existencia: ' + xhr.responseText);
                    }
                });
            });

            $('#formCardex').submit(function (event) {
                event.preventDefault();
                let formData = new FormData(this);
                let archivo = $('#archivo_cardex')[0].files[0];
                let lugar = $('#id_lugar').val();
                if (!archivo) {
                    alert('Por favor selecciona un archivo Excel');
                    return;
                }
                if (!lugar) {
                    alert('Por favor selecciona un lugar');
                    return;
                }
                let extension = archivo.name.split('.').pop().toLowerCase();
                if (extension !== 'xlsx' && extension !== 'xls') {
                    alert('Por favor selecciona un archivo Excel válido (.xlsx o .xls)');
                    return;
                }
                $('#progreso').show();
                $('#btnSubirCardex').prop('disabled', true);
                $.ajax({
                    url: '/materials/import-cardex',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    xhr: function () {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                let percentComplete = evt.loaded / evt.total * 100;
                                $('.progress-bar').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function (response) {
                        alert(response.message);
                        $('#modalCardex').modal('hide');
                        location.reload();
                    },
                    error: function (xhr) {
                        const res = xhr.responseJSON;
                        if (res?.errors) {
                            let errores = Object.values(res.errors).flat().join('\n');
                            alert('Errores de validación:\n' + errores);
                        } else if (res?.message) {
                            alert('Error: ' + res.message);
                        } else {
                            alert('Error al procesar el archivo: ' + xhr.responseText);
                        }
                    },
                    complete: function () {
                        $('#progreso').hide();
                        $('#btnSubirCardex').prop('disabled', false);
                        $('.progress-bar').css('width', '0%');
                    }
                });
            });

            $('#modalCardex').on('hidden.bs.modal', function () {
                $('#formCardex')[0].reset();
                $('#progreso').hide();
                $('.progress-bar').css('width', '0%');
            });
        });
    // Manejar el menú desplegable del perfil de usuario
            $('.user-profile').click(function(e) {
                e.stopPropagation();
                $('.user-dropdown').toggleClass('show');
            });

            // Cerrar el menú desplegable al hacer clic fuera
            $(document).click(function() {
                $('.user-dropdown').removeClass('show');
            });



    </script>
</body>

</html>
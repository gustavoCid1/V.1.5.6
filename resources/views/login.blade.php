<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inicia Sesión – FontTrack</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700" rel="stylesheet">

    <style>
        /* ───────── Reset & Base ───────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-size: 16px;
        }

        body {
            font-family: "Lato", Arial, sans-serif;
            color: #634D3B;
            height: 100vh;
            background: #F9E5D5;
            overflow: auto;
        }

        /* ───────── Animación de entrada ───────── */
        .transition-circle {
            position: fixed;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #634D3B 0%, #E38B5B 50%, #F4A978 100%);
            border-radius: 50%;
            z-index: 9998;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(35);
            animation: shrinkIn 1s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        @keyframes shrinkIn {
            to {
                transform: translate(-50%, -50%) scale(0);
            }
        }

        /* ───────── Animated Blobs ───────── */
        .blob-container {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: -1;
        }

        .blob {
            position: absolute;
            width: 60vmin;
            aspect-ratio: 1;
            border-radius: 40% 60% 30% 70% / 50% 30% 70% 50%;
            opacity: .4;
            animation: blobMove infinite ease-in-out;
        }

        .blob:nth-child(1) {
            background: #E38B5B;
            top: -10%;
            left: -10%;
            animation-duration: 12s;
        }

        .blob:nth-child(2) {
            background: #F6B88F;
            top: 60%;
            left: 5%;
            animation-duration: 10s;
        }

        .blob:nth-child(3) {
            background: #C49A6C;
            top: 20%;
            left: 70%;
            animation-duration: 8s;
        }

        .blob:nth-child(4) {
            background: #E38B5B;
            top: 40%;
            left: 85%;
            animation-duration: 15s;
            width: 40vmin;
        }

        .blob:nth-child(5) {
            background: #F6B88F;
            top: 10%;
            left: 40%;
            animation-duration: 14s;
            width: 30vmin;
        }

        @keyframes blobMove {
            0% {
                transform: scale(1) translate(0, 0) rotate(0deg);
                border-radius: 40% 60% 30% 70% / 50% 30% 70% 50%;
            }

            33% {
                transform: scale(1.2) translate(20px, -30px) rotate(120deg);
                border-radius: 60% 40% 70% 30% / 30% 70% 50% 50%;
            }

            66% {
                transform: scale(0.8) translate(-20px, 30px) rotate(240deg);
                border-radius: 30% 70% 50% 50% / 40% 60% 30% 70%;
            }

            100% {
                transform: scale(1) translate(0, 0) rotate(360deg);
                border-radius: 40% 60% 30% 70% / 50% 30% 70% 50%;
            }
        }

        /* ───────── Glassmorphism Card ───────── */
        .login-card {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 400px;
            padding: 2.5rem 2rem;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            z-index: 1;
            opacity: 0;
            animation: fadeInUp 1s ease-out 0.5s forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate(-50%, -40%) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .login-card .title {
            text-align: center;
            font-size: 1.75rem;
            color: #E38B5B;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .input-field {
            width: 100%;
            margin-bottom: 1rem;
            padding: .75rem 1rem;
            border: 1px solid #E0C4AA;
            border-radius: 8px;
            background: #fffaf6;
            transition: border-color .3s;
        }

        .input-field:focus {
            border-color: #E38B5B;
            outline: none;
        }

        .alert {
            display: block;
            font-size: .875rem;
            color: #D9534F;
            margin: -0.5rem 0 1rem;
        }

        /* ───────── Animated Buttons ───────── */
        .btn-animated {
            text-transform: uppercase;
            text-decoration: none;
            font-weight: 700;
            border: 0;
            position: relative;
            letter-spacing: 0.15em;
            margin: 0.5rem auto;
            padding: 1rem 2.5rem;
            background: transparent;
            outline: none;
            font-size: 1rem;
            color: #634D3B;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.15s;
            cursor: pointer;
            display: block;
            width: 100%;
            border-radius: 8px;
        }

        .btn-animated::after,
        .btn-animated::before {
            border: 0;
            content: "";
            position: absolute;
            height: 40%;
            width: 10%;
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: -10;
            border-radius: 50%;
        }

        .btn-animated.btn-primary::before {
            background-color: #D1784C;
            top: -0.75rem;
            left: 0.5rem;
            animation: topAnimation 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.25s infinite alternate;
        }

        .btn-animated.btn-primary::after {
            background-color: #E38B5B;
            top: 3rem;
            left: calc(100% - 2rem);
            animation: bottomAnimation 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.5s infinite alternate;
        }

        .btn-animated.btn-secondary::before {
            background-color: #A9866A;
            top: -0.75rem;
            left: 0.5rem;
            animation: topAnimation 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.25s infinite alternate;
        }

        .btn-animated.btn-secondary::after {
            background-color: #c49a6c;
            top: 3rem;
            left: calc(100% - 2rem);
            animation: bottomAnimation 2s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.5s infinite alternate;
        }

        .btn-animated:hover {
            color: white;
        }

        .btn-animated:hover::before,
        .btn-animated:hover::after {
            top: 0;
            height: 100%;
            width: 100%;
            border-radius: 8px;
            animation: none;
        }

        .btn-animated:hover::after {
            left: 0rem;
        }

        .btn-animated:hover::before {
            top: 0rem;
            left: 0rem;
        }

        @keyframes topAnimation {
            from {
                transform: translate(0rem, 0);
            }
            to {
                transform: translate(0rem, 3.5rem);
            }
        }

        @keyframes bottomAnimation {
            from {
                transform: translate(-80%, 0);
            }
            to {
                transform: translate(0rem, 0);
            }
        }

        /* ── Clase para centrar "Regresar" ── */
        .btn-secondary.center-btn {
            display: block;
            margin: 1rem auto 0;
            text-align: center;
            width: 100%;
        }

        .btn-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            color: #634D3B;
            font-size: .9rem;
            text-decoration: none;
        }

        .btn-link:hover {
            color: #E38B5B;
        }

        /* ───────── Modal Overrides ───────── */
        .modal .form-control {
            background: #fffaf6;
            border: 1px solid #E0C4AA;
            border-radius: 6px;
        }

        .modal .form-control:focus {
            border-color: #E38B5B;
            box-shadow: none;
        }

        .modal-header {
            background: #F6B88F;
            border-bottom: 2px solid #E38B5B;
        }

        .modal-title {
            color: #634D3B;
            font-weight: bold;
        }

        .modal .btn-primary {
            background: #E38B5B;
            border: none;
            border-radius: 6px;
        }

        .modal .btn-primary:hover {
            background: #D1784C;
        }

        .modal .btn-secondary {
            background: #c49a6c;
            border: none;
            border-radius: 6px;
        }

        .modal .btn-secondary:hover {
            background: #A9866A;
        }

        /* ───────── Responsive: Tablets ───────── */
        @media (max-width: 768px) {
            .login-card {
                width: 95%;
                padding: 2rem 1.5rem;
            }

            .login-card .title {
                font-size: 1.5rem;
            }

            .input-field {
                padding: .65rem .85rem;
            }

            .btn-animated {
                padding: .65rem 2rem;
                font-size: 0.9rem;
            }

            .blob {
                width: 50vmin;
            }

            .blob:nth-child(4) {
                width: 35vmin;
            }

            .blob:nth-child(5) {
                width: 25vmin;
            }
        }

        /* ───────── Responsive: Móviles ───────── */
        @media (max-width: 576px) {
            html {
                font-size: 14px;
            }

            .login-card {
                padding: 1.5rem 1rem;
            }

            .login-card .title {
                font-size: 1.25rem;
            }

            .input-field {
                padding: .5rem .75rem;
                font-size: .9rem;
            }

            .btn-animated {
                padding: .5rem 1.5rem;
                font-size: .9rem;
            }

            .blob {
                width: 40vmin;
            }

            .blob:nth-child(4) {
                width: 30vmin;
            }

            .blob:nth-child(5) {
                width: 20vmin;
            }
        }
    </style>
</head>

<body>
    {{-- Círculo de transición de entrada --}}
    <div class="transition-circle" id="transitionCircle"></div>

    {{-- Blobs animados de fondo --}}
    <div class="blob-container">
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>
        <div class="blob"></div>
    </div>

    {{-- Tarjeta de Login --}}
    <div class="login-card">
        <h4 class="title">Inicia Sesión</h4>
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <input id="logemail" name="correo" type="email" class="input-field" placeholder="Correo" required
                autocomplete="off" value="{{ old('correo') }}">
            @error('correo') <span class="alert">{{ $message }}</span> @enderror
            <span class="alert" id="emailError" style="display: none;">El correo debe ser del dominio @bonafont.com</span>

            <input id="logpass" name="password" type="password" class="input-field" placeholder="Contraseña" required
                autocomplete="off">
            @error('password') <span class="alert">{{ $message }}</span> @enderror

            <button type="submit" class="btn-animated btn-primary">Entrar</button>
            <a href="{{ url('/') }}" class="btn-animated btn-secondary center-btn">Regresar</a>
            <a href="#" class="btn-link" data-bs-toggle="modal" data-bs-target="#modalRegistro"
                id="btnNuevoUsuario">Registrar</a>
            <a href="#" class="btn-link">¿Olvidaste tu contraseña?</a>
            <img src="{{ asset('img/by.png') }}" alt="by" style="display: block; margin: 1rem auto; max-width: 150px;">
        </form>
    </div>

    {{-- Modal de Registro/Edición --}}
    <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formRegistro" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="usuarioId" name="id_usuario">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRegistroLabel">
                            Registrar Usuario
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="correoRegistro" class="form-label">Correo:</label>
                            <input type="email" id="correoRegistro" name="correo" class="form-control" required>
                            <small class="text-muted">Debe ser un correo @bonafont.com</small>
                        </div>
                        <div class="mb-3">
                            <label for="passwordRegistro" class="form-label">
                                Contraseña:
                            </label>
                            <input type="password" id="passwordRegistro" name="password" class="form-control" required>
                        </div>
                        <input type="hidden" id="tipo_usuario" name="tipo_usuario" value="2">
                        <div class="mb-3">
                            <label for="foto_usuario" class="form-label">
                                Foto de Perfil:
                            </label>
                            <input type="file" id="foto_usuario" name="foto_usuario" class="form-control"
                                accept="image/png, image/jpeg">
                            <small class="text-muted">Si no selecciona una imagen, se usará la foto por defecto</small>
                        </div>
                        <div class="mb-3">
                            <label for="id_lugar" class="form-label">Lugar:</label>
                            <select id="id_lugar" name="id_lugar" class="form-control">
                                @foreach($lugares as $lugar)
                                    <option value="{{ $lugar->id_lugar }}">
                                        {{ $lugar->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS & jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('transitionCircle').style.display = 'none';
            }, 1500);
        });

        // Validación de correo @bonafont.com en login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('logemail').value;
            const emailError = document.getElementById('emailError');
            
            if (!email.endsWith('@bonafont.com')) {
                e.preventDefault();
                emailError.style.display = 'block';
                return false;
            } else {
                emailError.style.display = 'none';
            }
        });

        // Validación en tiempo real
        document.getElementById('logemail').addEventListener('input', function() {
            const email = this.value;
            const emailError = document.getElementById('emailError');
            
            if (email && !email.endsWith('@bonafont.com')) {
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
        });

        // AJAX registro/edición
        $('#formRegistro').submit(function (e) {
            e.preventDefault();
            
            // Validar correo @bonafont.com en registro
            const correoRegistro = $('#correoRegistro').val();
            if (!correoRegistro.endsWith('@bonafont.com')) {
                alert('El correo debe ser del dominio @bonafont.com');
                return false;
            }
            
            const id = $('#usuarioId').val();
            const url = id ? `/modal/update_user/${id}` : `/modal/register_user`;
            const method = id ? 'PUT' : 'POST';
            const data = new FormData(this);
            
            // Si no hay foto seleccionada, agregar la foto por defecto
            if (!$('#foto_usuario')[0].files.length) {
                data.append('foto_default', 'Sin_Foto.png');
            }

            $.ajax({
                url, method, data,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success(res) { 
                    alert(res.message); 
                    location.reload(); 
                },
                error(err) {
                    const msgs = err.responseJSON?.errors || {};
                    alert(Object.values(msgs).flat().join('\n'));
                }
            });
        });

        // Reset al abrir modal
        $('#btnNuevoUsuario').on('click', function () {
            $('#formRegistro')[0].reset();
            $('#usuarioId').val('');
            $('#tipo_usuario').val('2'); // Siempre usuario
        });

        // Validación en tiempo real para registro
        $('#correoRegistro').on('input', function() {
            const email = $(this).val();
            if (email && !email.endsWith('@bonafont.com')) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    </script>
</body>

</html>
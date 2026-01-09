<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --azul-claro: #EAF2FF;
            --azul-medio: #5DA9FF;
            --azul-principal: #1E6FE8;
            --azul-oscuro: #123C8C;
            --blanco: #FFFFFF;
            --gris: #3A3A3A;
        }

        body {
            background-color: var(--azul-claro);
            height: 100vh; /* Ocupar toda la altura de la pantalla */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: var(--blanco);
            width: 100%;
            max-width: 400px; /* Ancho máximo de la tarjeta */
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            padding: 40px 30px;
            border-top: 5px solid var(--azul-principal);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-icon {
            font-size: 3rem;
            color: var(--azul-principal);
            margin-bottom: 10px;
        }

        .form-control:focus {
            border-color: var(--azul-medio);
            box-shadow: 0 0 0 0.25rem rgba(30, 111, 232, 0.25);
        }

        .btn-login {
            background-color: var(--azul-principal);
            border: none;
            color: var(--blanco);
            font-size: 1.1rem;
            font-weight: 500;
            padding: 12px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: var(--azul-oscuro);
            transform: translateY(-2px);
        }

        .forgot-link {
            color: var(--azul-oscuro);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-link:hover {
            color: var(--azul-principal);
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        
        <!-- CABECERA CON ICONO -->
        <div class="login-header">
            <i class="bi bi-person-circle login-icon"></i>
            <h2 class="fw-bold" style="color: var(--gris);">Bienvenido</h2>
            <p class="text-muted">Ingresa tus credenciales para continuar</p>
        </div>

        <!-- FORMULARIO -->
        <form action="procesar_login.php" method="POST">

            <!-- CAMPO CORREO -->
            <div class="mb-3">
                <label for="correo" class="form-label fw-bold text-muted small">CORREO ELECTRÓNICO</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0 ps-0 bg-light" id="correo" name="correo" placeholder="ejemplo@correo.com" required>
                </div>
            </div>

            <!-- CAMPO CONTRASEÑA -->
            <div class="mb-4">
                <label for="contraseña" class="form-label fw-bold text-muted small">CONTRASEÑA</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control border-start-0 ps-0 bg-light" id="contraseña" name="contraseña" placeholder="••••••••" required>
                </div>
            </div>

            <!-- BOTÓN INGRESAR -->
            <div class="d-grid mb-4">
                <button type="submit" class="btn btn-login shadow-sm">Ingresar</button>
            </div>

            <!-- LINK RECUPERAR -->
            <div class="text-center">
                <a href="recuperar_contraseña.php" class="forgot-link">¿Olvidaste tu contraseña?</a>
            </div>

        </form>
    </div>

    <!-- Script de Bootstrap (Opcional si no usas componentes interactivos, pero recomendado) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
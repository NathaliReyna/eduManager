{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduManager - Iniciar sesión</title>

    <!-- Fuente (opcional) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #e9f0ff;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }
        .texto_login{
            
            flex-direction:column;
            text-align:center;
            justify-content:center;
        }
        .texto_login .login_description{
            display:flex;
            flex-direction:column;
            text-align:center;
            justify-content: center;
        }

        .login-container {
            height: 100vh;
            display: flex;
        }

        /* Imagen izquierda */
        .login-image {
            width: 50%;
            background-image: url('/img/imagenlogin.png');
            background-position: center;
            background-size: cover;
            border-radius: 0 30px 30px 0;
        }

        /* Sección derecha */
        .login-form-area {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-box {
            width: 90%;
            max-width: 450px;
        }

        /* Encabezado */
        .login-logo-box {
            background: #2563eb;
            padding: 18px;
            border-radius: 22px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 16px;
            width: 78px;
            height: 78px;
        }

        .login-title {
            font-size: 32px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 3px;
        }

        .login-subtitle {
            font-size: 15px;
            color: #6b7280;
            font-weight: 600;
            margin-bottom: 2px;
        }

        /* Tarjeta de formulario */
        .login-card {
            background: #ffffff;
            padding: 28px 35px;
            border-radius: 14px;
            margin-top: 22px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border: 1px solid #e5e7eb;
        }

        .login-card-title {
            font-weight: 700;
            color: #374151;
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* Label */
        .form-label {
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }

        /* Inputs */
        .login-input {
            width: 92%;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px 14px;
            margin-top: 6px;
            margin-bottom: 18px;
            font-size: 15px;
            transition: 0.2s;
        }

        .login-input:focus {
            border-color: #2563eb;
            outline: none;
        }

        /* Botón */
        .login-btn {
            background-color: #2563eb;
            color: white;
            padding: 13px;
            border-radius: 10px;
            width: 100%;
            font-size: 16px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: .2s;
        }

        .login-btn:hover {
            background-color: #1d4ed8;
        }

        .login-description {
            color: #6b7280;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
<!-- Vista principal -->

<div class="login-container">

    <!-- Imagen izquierda -->
    <div class="login-image"></div>

    <!-- Formulario -->
    <div class="login-form-area">
        <div class="login-box">

            <!-- Logo + títulos -->
            <div class="flex flex-col items-center text-center texto_login">

                
                <img src="/img/logo.png" width="80">
                

                <h1 class="login-title">EduManager</h1>
                <p class="login-subtitle">Sistema de Gestión Académica</p>

                <p class="login-description style: text-align:center">
                    ¡Qué bueno tenerte de vuelta! Inicia sesión para acceder a tu cuenta.
                </p>
            </div>

            <!-- Tarjeta -->
            <div class="login-card">

                <p class="login-card-title">Bienvenido, inicie sesión.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- EMAIL -->
                    <label class="form-label">Correo electrónico</label>
                    <input id="email" type="email" name="email" required autofocus class="login-input">

                    <!-- PASSWORD -->
                    <label class="form-label">Contraseña</label>
                    <input id="password" type="password" name="password" required class="login-input">

                    <!-- BOTÓN -->
                    <button class="login-btn">Acceder al sistema</button>
                </form>

            </div>

        </div>
    </div>

</div>

</body>
</html>

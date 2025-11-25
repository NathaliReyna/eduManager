<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EduManager</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }

        body { display: flex; background: #f7f7f7; }

        .sidebar {
            width: 260px;
    min-height: 100vh;   /* Altura completa visible */
    height: auto;        /* Permite crecer si el contenido es mayor */
    background: white;
    border-right: 1px solid #e5e5e5;
    padding: 25px;

    display: flex;
    flex-direction: column;   /* Acomoda elementos hacia abajo */
    justify-content: flex-start;
        }

        .logo h2 { font-size: 20px; font-weight: bold; }

        .menu { margin-top: 40px; display: flex; flex-direction: column; gap: 15px; }

        .menu a {
            padding: 12px 15px;
            text-decoration: none;
            color: #333;
            border-radius: 10px;
            display: block;
        }

        .menu a:hover,
        .menu a.active {
            background: #eef4ff;
            color: #3164f4;
            font-weight: bold;
        }

        .logout {
            padding: 12px;
            background: #ffe5e5;
            text-align: center;
            border-radius: 10px;
            margin-top: auto;      /* Empuja el logout hacia abajo */
    margin-bottom: 30px;
        }

        .logout a {
            color: #d9534f;
            text-decoration: none;
            font-weight: bold;
        }

        .content {
            flex: 1;
            padding: 40px;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div>
            <div class="logo">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo-icon">
            <div>
                <h2>EduManager</h2>
                <p>Sistema Académico</p>
            </div>
            </div>

            <div class="menu" style="display:flex, align-items:center, justify-content:center">
                <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <img src="{{ asset('img/dash1.png') }}" class="menu-icon" style="width:16px">
                Dashboard
            </a>
                <a href="{{ route('alumnos.index') }}" class="{{ request()->is('alumnos') ? 'active' : '' }}">
                <img src="{{ asset('img/alu1.png') }}" class="menu-icon" style="width:16px" >
                Alumnos
            </a>

            <a href="{{ route('docentes.index') }}" class="{{ request()->is('docentes') ? 'active' : '' }}">
                <img src="{{ asset('img/doc1.png') }}" class="menu-icon" style="width:16px">
                Docentes
            </a>

            <a href="{{ route('cursos.index') }}" class="{{ request()->is('cursos') ? 'active' : '' }}">
                <img src="{{ asset('img/cur1.png') }}" class="menu-icon" style="width:16px">
                Cursos
            </a>

            <a href="{{ route('matriculas.index') }}" class="{{ request()->is('matriculas') ? 'active' : '' }}">
                <img src="{{ asset('img/mat1.png') }}" class="menu-icon" style="width:16px">
                Matrículas
            </a>
            </div>
        </div>

        <div class="logout">
            <a href="#">Cerrar Sesión</a>
        </div>
    </div>

    <!-- CONTENIDO -->
    <div class="content">
        @yield('contenido')
    </div>

</body>
</html>


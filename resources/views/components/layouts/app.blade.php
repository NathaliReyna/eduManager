<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EduManager' }}</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100">

    {{-- Aquí Livewire insertará su contenido --}}
    {{ $slot }}

    @livewireScripts
</body>
</html>
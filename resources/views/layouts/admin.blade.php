<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Administración') — RESOL</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-blue-700 text-white px-4 py-3 flex items-center justify-between shadow"
         wire:ignore>
        <div class="flex items-center gap-4">
            <span class="font-bold text-lg">RESOL — Administración</span>
            <a href="{{ route('admin.dashboard') }}"
               class="text-sm opacity-80 hover:opacity-100 hover:underline">
                Inicio
            </a>
            <a href="{{ route('admin.cotizacion') }}"
               class="text-sm opacity-80 hover:opacity-100 hover:underline">
                Cotizaciones
            </a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm opacity-80">{{ Auth::guard('admin')->user()->nombre }}</span>
            <button type="button" onclick="cerrarSesion()"
                    class="text-sm bg-blue-800 hover:bg-blue-900 px-3 py-1 rounded">
                Salir
            </button>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/alpine2.min.js') }}"></script>
    @livewireScripts
    <script>
        function cerrarSesion() {
            fetch('{{ route('logout') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                credentials: 'same-origin'
            }).then(function() {
                window.location.href = '/';
            }).catch(function() {
                window.location.href = '/';
            });
        }
    </script>
</body>
</html>

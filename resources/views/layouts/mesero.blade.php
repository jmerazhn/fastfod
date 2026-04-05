<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>RESOL — Comandas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-blue-700 text-white px-4 py-3 flex items-center justify-between shadow">
        <a href="{{ route('mesas') }}" class="font-bold text-lg tracking-wide">RESOL Comandas</a>
        <div class="flex items-center gap-4">
            <span class="text-sm opacity-80">{{ auth()->user()->nombre }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm bg-blue-800 hover:bg-blue-900 px-3 py-1 rounded">
                    Salir
                </button>
            </form>
        </div>
    </nav>

    <!-- Contenido -->
    <main class="p-4">
        {{ $slot }}
    </main>

    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/alpinejs@2.8.2/dist/alpine.js"></script>
    @livewireScripts
</body>
</html>

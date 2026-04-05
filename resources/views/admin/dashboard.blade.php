<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-700 text-white px-4 py-3 flex items-center justify-between shadow">
        <span class="font-bold text-lg">RESOL — Administración</span>
        <div class="flex items-center gap-4">
            <span class="text-sm opacity-80">{{ Auth::guard('admin')->user()->nombre }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm bg-blue-800 hover:bg-blue-900 px-3 py-1 rounded">
                    Salir
                </button>
            </form>
        </div>
    </nav>
    <main class="p-8 text-center text-gray-500">
        Módulo de administración en construcción.
    </main>
</body>
</html>

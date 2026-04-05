<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESOL — Comandas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-sm">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-1">RESOL</h1>
        <p class="text-center text-gray-500 mb-6 text-sm">Sistema de Comandas</p>

        @if(session('status'))
            <div class="bg-green-100 text-green-700 rounded p-3 mb-4 text-sm">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 rounded p-3 mb-4 text-sm">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="correo">Correo o nombre de usuario</label>
                <input
                    id="correo"
                    name="correo"
                    type="text"
                    value="{{ old('correo') }}"
                    required
                    autofocus
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="correo@ejemplo.com o nombre"
                >
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Contraseña</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="••••••••"
                >
            </div>

            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
            >
                Ingresar
            </button>
        </form>
    </div>
</body>
</html>

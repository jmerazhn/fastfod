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
    <main class="p-8">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-xl font-bold text-gray-700 mb-6">Módulos disponibles</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('admin.cotizacion') }}"
                   class="flex items-center gap-4 bg-white rounded-xl shadow p-5 hover:shadow-md hover:border-blue-300 border border-transparent transition">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">Cotizaciones</div>
                        <div class="text-sm text-gray-500">Genera cotizaciones en PDF</div>
                    </div>
                </a>
            </div>
        </div>
    </main>
</body>
</html>

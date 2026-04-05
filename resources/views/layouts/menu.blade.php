<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Menú</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .category-img { object-fit: cover; width: 100%; height: 100%; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen" style="font-family: 'Segoe UI', sans-serif;">
    {{ $slot }}
    <script src="https://unpkg.com/alpinejs@2.8.2/dist/alpine.js"></script>
    @livewireScripts
</body>
</html>

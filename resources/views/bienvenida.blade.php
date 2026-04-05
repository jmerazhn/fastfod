<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Salem Cacao y Café — Bienvenido</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #1a0a00 0%, #3b1a08 50%, #6b3a1f 100%);
            font-family: 'Segoe UI', sans-serif;
            padding: 24px;
        }
        .card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px;
            padding: 36px 28px;
            max-width: 400px;
            width: 100%;
            text-align: center;
            backdrop-filter: blur(10px);
        }
        .logo-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d97706, #92400e);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.8rem;
            box-shadow: 0 8px 32px rgba(217,119,6,0.4);
        }
        h1 {
            color: #fef3c7;
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.2;
        }
        .subtitulo {
            color: #d97706;
            font-size: 0.95rem;
            margin-top: 4px;
            font-weight: 500;
            letter-spacing: 0.05em;
        }
        .divider {
            height: 1px;
            background: rgba(255,255,255,0.1);
            margin: 24px 0;
        }
        .mensaje {
            color: #e5d4b0;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .btn-wifi {
            display: block;
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #d97706, #b45309);
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(217,119,6,0.5);
            transition: opacity 0.2s;
        }
        .btn-wifi:hover { opacity: 0.9; }
        .redes {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 20px;
        }
        .btn-red {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s;
            border: none;
            cursor: pointer;
        }
        .btn-red:hover { opacity: 0.85; }
        .btn-instagram { background: linear-gradient(135deg,#833ab4,#fd1d1d,#fcb045); color:#fff; }
        .btn-facebook  { background: #1877f2; color: #fff; }
        .btn-menu {
            display: block;
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fef3c7;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 14px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-menu:hover { background: rgba(255,255,255,0.14); }
        .nota {
            color: rgba(255,255,255,0.3);
            font-size: 0.72rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="card">

        <div class="logo-circle">☕</div>

        <h1>Salem Cacao y Café</h1>
        <p class="subtitulo">¡Bienvenido!</p>

        <div class="divider"></div>

        <p class="mensaje">
            Conéctate a nuestro WiFi gratis y disfruta tu visita.<br>
            Síguenos en redes para enterarte de nuestras promociones.
        </p>

        {{-- Botón principal --}}
        <form method="POST" action="{{ route('bienvenida.autorizar') }}">
            @csrf
            <input type="hidden" name="mac" value="{{ $mac }}">
            <input type="hidden" name="url_origen" value="{{ $url_origen }}">
            <button type="submit" class="btn-wifi">
                📶 &nbsp; Acceder al WiFi
            </button>
        </form>

        {{-- Redes sociales --}}
        <div class="redes">
            <a href="https://www.instagram.com/salemcyc" target="_blank" class="btn-red btn-instagram">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                Instagram
            </a>
            <a href="https://www.facebook.com/salemcyc" target="_blank" class="btn-red btn-facebook">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Facebook
            </a>
        </div>

        {{-- Ver menú --}}
        <a href="{{ route('menu') }}" class="btn-menu">🍽️ &nbsp; Ver nuestro menú</a>

        <p class="nota">Al conectarte aceptas el uso responsable de la red.</p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartelito — Salem Cacao y Café</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f0f0f0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 16px;
            gap: 24px;
        }

        .controles {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .controles button {
            padding: 10px 24px;
            background: #d97706;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
        }

        .controles button:hover { background: #b45309; }

        .cartelito {
            width: 320px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
            background: #fff;
        }

        .header {
            background: linear-gradient(135deg, #1a0a00, #6b3a1f);
            padding: 24px 20px 20px;
            text-align: center;
        }

        .cafe-icon {
            font-size: 3rem;
            display: block;
            margin-bottom: 8px;
        }

        .header h1 {
            color: #fef3c7;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.2;
        }

        .header p {
            color: #d97706;
            font-size: 0.8rem;
            margin-top: 4px;
            font-weight: 500;
            letter-spacing: 0.05em;
        }

        .cuerpo {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
        }

        .wifi-box {
            width: 100%;
            background: #fef3c7;
            border-radius: 12px;
            padding: 14px 16px;
            text-align: center;
        }

        .wifi-box .etiqueta {
            font-size: 0.7rem;
            color: #92400e;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }

        .wifi-box .valor {
            font-size: 1rem;
            font-weight: 700;
            color: #1a0a00;
        }

        .wifi-box .clave {
            font-size: 1.2rem;
            font-weight: 800;
            color: #d97706;
            letter-spacing: 0.1em;
            margin-top: 2px;
        }

        .qr-wrapper {
            background: #fff;
            padding: 10px;
            border-radius: 12px;
            border: 2px solid #fef3c7;
        }

        .instruccion {
            font-size: 0.82rem;
            color: #6b7280;
            text-align: center;
            line-height: 1.5;
        }

        .instruccion strong {
            color: #d97706;
        }

        .footer {
            background: #1a0a00;
            padding: 12px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .footer a {
            color: #d97706;
            font-size: 0.75rem;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .controles { display: none; }
            .cartelito { box-shadow: none; }
        }
    </style>
</head>
<body>

    <div class="controles">
        <button onclick="window.print()">🖨️ Imprimir</button>
    </div>

    <div class="cartelito">

        <div class="header">
            <span class="cafe-icon">☕</span>
            <h1>Salem Cacao y Café</h1>
            <p>¡Bienvenido!</p>
        </div>

        <div class="cuerpo">

            <div class="wifi-box">
                <div class="etiqueta">📶 Conéctate al WiFi</div>
                <div class="valor">{{ $ssid }}</div>
                @if($password)
                    <div class="etiqueta" style="margin-top:10px">🔑 Contraseña</div>
                    <div class="clave">{{ $password }}</div>
                @else
                    <div class="etiqueta" style="margin-top:6px;color:#059669">Red abierta — sin contraseña</div>
                @endif
            </div>

            <div class="qr-wrapper">
                <div id="qrcode"></div>
            </div>

            <p class="instruccion">
                📱 <strong>Escanea el QR</strong> para ver<br>
                nuestro menú y seguirnos en redes
            </p>

        </div>

        <div class="footer">
            <a href="https://www.instagram.com/salemcyc" target="_blank">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                @salemcyc
            </a>
            <a href="https://www.facebook.com/salemcyc" target="_blank">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                @salemcyc
            </a>
        </div>

    </div>

    <script src="{{ asset('js/qrcode.min.js') }}"></script>
    <script>
        new QRCode(document.getElementById('qrcode'), {
            text: '{{ $url_menu }}',
            width: 180,
            height: 180,
            colorDark: '#1a0a00',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>

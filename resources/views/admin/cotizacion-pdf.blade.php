<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            padding: 24px 40px;
        }

        /* ---- Encabezado ---- */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }
        .header-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }
        .header-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        .negocio-nombre {
            font-size: 20px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 4px;
        }
        .negocio-detalle {
            font-size: 10px;
            color: #555;
            line-height: 1.5;
        }
        .doc-titulo {
            font-size: 22px;
            font-weight: bold;
            color: #1e40af;
            letter-spacing: 1px;
        }
        .doc-numero {
            font-size: 13px;
            font-weight: bold;
            color: #374151;
            margin-top: 4px;
        }
        .doc-fecha {
            font-size: 10px;
            color: #555;
            margin-top: 4px;
            line-height: 1.6;
        }

        /* ---- Línea separadora ---- */
        .divider {
            border: none;
            border-top: 2px solid #1e40af;
            margin-bottom: 20px;
        }

        /* ---- Bloque cliente ---- */
        .cliente-box {
            background: #f1f5f9;
            border-left: 4px solid #1e40af;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
        .cliente-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .cliente-nombre {
            font-size: 13px;
            font-weight: bold;
            color: #1e293b;
        }
        .cliente-detalle {
            font-size: 10px;
            color: #475569;
            margin-top: 2px;
        }

        /* ---- Tabla de productos ---- */
        .tabla-productos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .tabla-productos thead tr {
            background: #1e40af;
            color: #fff;
        }
        .tabla-productos thead th {
            padding: 8px 10px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .tabla-productos tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        .tabla-productos tbody tr:nth-child(odd) {
            background: #ffffff;
        }
        .tabla-productos tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* ---- Totales ---- */
        .totales-wrapper {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .totales-spacer { display: table-cell; width: 55%; }
        .totales-tabla-cell { display: table-cell; width: 45%; vertical-align: top; }
        .totales-tabla {
            width: 100%;
            border-collapse: collapse;
        }
        .totales-tabla td {
            padding: 5px 10px;
            font-size: 11px;
        }
        .totales-tabla tr:not(:last-child) td {
            border-bottom: 1px solid #e2e8f0;
        }
        .totales-tabla .fila-total td {
            background: #1e40af;
            color: #fff;
            font-weight: bold;
            font-size: 13px;
            border-radius: 2px;
        }

        /* ---- Notas ---- */
        .notas-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 3px;
            padding: 10px 14px;
            margin-bottom: 20px;
        }
        .notas-label {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #92400e;
            margin-bottom: 4px;
        }
        .notas-texto {
            font-size: 10px;
            color: #374151;
            line-height: 1.5;
        }

        /* ---- Pie ---- */
        .footer {
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
            font-size: 9px;
            color: #94a3b8;
            text-align: center;
        }
        .validez-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            font-size: 9px;
            font-weight: bold;
            padding: 3px 8px;
            border-radius: 20px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>

    {{-- Encabezado --}}
    <div class="header">
        <div class="header-left">
            @if(!empty($negocio['logo_base64']))
                <img src="{{ $negocio['logo_base64'] }}"
                     style="height:60px; width:auto; margin-bottom:6px; display:block;">
            @endif
            <div class="negocio-nombre">{{ $negocio['nombre'] }}</div>
            <div class="negocio-detalle">
                @if($negocio['rtn'])       RTN: {{ $negocio['rtn'] }}<br>@endif
                @if($negocio['direccion']) {{ $negocio['direccion'] }}<br>@endif
                @if($negocio['telefono'])  Tel: {{ $negocio['telefono'] }}<br>@endif
                @if($negocio['correo'])    {{ $negocio['correo'] }}@endif
            </div>
        </div>
        <div class="header-right">
            <div class="doc-titulo">COTIZACIÓN</div>
            <div class="doc-numero">{{ $numeroCotizacion }}</div>
            <div class="doc-fecha">
                Fecha: {{ $fecha }}<br>
                Válida hasta: {{ $fechaVence }}
            </div>
        </div>
    </div>

    <hr class="divider">

    {{-- Bloque cliente --}}
    <div class="cliente-box">
        <div class="cliente-label">Cotización para</div>
        <div class="cliente-nombre">{{ $clienteNombre ?: 'Consumidor Final' }}</div>
        @if($clienteEmpresa)
            <div class="cliente-detalle">{{ $clienteEmpresa }}</div>
        @endif
        @if($clienteRtn)
            <div class="cliente-detalle">RTN: {{ $clienteRtn }}</div>
        @endif
        @if($clienteCorreo)
            <div class="cliente-detalle">{{ $clienteCorreo }}</div>
        @endif
    </div>

    {{-- Tabla de productos --}}
    <table class="tabla-productos">
        <thead>
            <tr>
                <th style="width:6%">#</th>
                <th style="text-align:left">Descripción</th>
                <th style="width:14%;text-align:right">P. Unitario</th>
                <th style="width:12%;text-align:center">Cant.</th>
                <th style="width:16%;text-align:right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $item)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $item['nombre'] }}</td>
                <td class="text-right">{{ $currency }} {{ number_format($item['precio'], 2) }}</td>
                <td class="text-center">{{ $item['cantidad'] }}</td>
                <td class="text-right">{{ $currency }} {{ number_format(round($item['precio'] * $item['cantidad'], 2), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totales --}}
    <div class="totales-wrapper">
        <div class="totales-spacer"></div>
        <div class="totales-tabla-cell">
            <table class="totales-tabla">
                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">{{ $currency }} {{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>ISV 15%</td>
                    <td class="text-right">{{ $currency }} {{ number_format($isv, 2) }}</td>
                </tr>
                <tr class="fila-total">
                    <td>TOTAL</td>
                    <td class="text-right">{{ $currency }} {{ number_format($total, 2) }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Notas --}}
    @if($notas)
    <div class="notas-box">
        <div class="notas-label">Notas y condiciones</div>
        <div class="notas-texto">{{ $notas }}</div>
    </div>
    @endif

    {{-- Validez --}}
    <div style="margin-bottom: 16px;">
        <span class="validez-badge">
            Esta cotización es válida por {{ $validezDias }} días a partir del {{ $fecha }}
        </span>
    </div>

    {{-- Pie --}}
    <div class="footer">
        Documento generado por {{ $negocio['nombre'] }} — {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>

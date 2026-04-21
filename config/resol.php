<?php

return [
    'currency'            => env('CURRENCY_SYMBOL', '$'),
    'currency_symbol'     => env('CURRENCY_SYMBOL', '$'),
    'printer_barra'       => env('PRINTER_BARRA', 'EPSON-TMU220'),
    'printer_cocina_ip'   => env('PRINTER_COCINA_IP', ''),
    'printer_cocina_port' => env('PRINTER_COCINA_PORT', 9100),
    'img_path'            => env('RESOL_IMG_PATH', 'C:\Program Files (x86)\TechSupport\Sistema de Restaurante\resources\img'),

    // Datos del negocio para cotizaciones y facturas
    'negocio_logo'        => env('NEGOCIO_LOGO', ''),
    'negocio_nombre'      => env('NEGOCIO_NOMBRE', 'Mi Negocio'),
    'negocio_rtn'         => env('NEGOCIO_RTN', ''),
    'negocio_direccion'   => env('NEGOCIO_DIRECCION', ''),
    'negocio_telefono'    => env('NEGOCIO_TELEFONO', ''),
    'negocio_correo'      => env('NEGOCIO_CORREO', ''),
    'cotizacion_validez'  => (int) env('COTIZACION_VALIDEZ_DIAS', 15),
];

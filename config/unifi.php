<?php

return [
    'host'         => env('UNIFI_HOST', '192.168.1.1'),
    'port'         => env('UNIFI_PORT', 8443),
    'user'         => env('UNIFI_USER', 'admin'),
    'password'     => env('UNIFI_PASSWORD', ''),
    'site'         => env('UNIFI_SITE', 'default'),
    'wifi_ssid'    => env('WIFI_SSID', 'WiFi'),
    'wifi_password'=> env('WIFI_PASSWORD', ''),
];

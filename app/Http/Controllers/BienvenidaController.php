<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BienvenidaController extends Controller
{
    public function show(Request $request)
    {
        return view('bienvenida', [
            'mac'        => $request->query('id', ''),
            'ap'         => $request->query('ap', ''),
            'url_origen' => $request->query('url', 'http://www.google.com'),
        ]);
    }

    public function autorizar(Request $request)
    {
        $mac = $request->input('mac');

        if (empty($mac)) {
            return redirect()->route('bienvenida')->with('error', 'No se pudo identificar el dispositivo.');
        }

        try {
            $host  = config('unifi.host');
            $port  = config('unifi.port');
            $site  = config('unifi.site');
            $base  = "https://{$host}:{$port}";

            $client = Http::withOptions(['verify' => false])->withHeaders([
                'Content-Type' => 'application/json',
            ]);

            // Login al controller
            $login = $client->post("{$base}/api/login", [
                'username' => config('unifi.user'),
                'password' => config('unifi.password'),
            ]);

            if (!$login->successful()) {
                \Log::error('Unifi login falló: ' . $login->body());
                return $this->redirigirInternet($request->input('url_origen'));
            }

            $cookies = $login->cookies();

            // Autorizar el MAC por 8 horas
            Http::withOptions(['verify' => false])
                ->withHeaders(['Content-Type' => 'application/json'])
                ->withCookies($cookies->toArray(), $host)
                ->post("{$base}/api/s/{$site}/cmd/stamgr", [
                    'cmd'     => 'authorize-guest',
                    'mac'     => $mac,
                    'minutes' => 480,
                ]);

        } catch (\Exception $e) {
            \Log::error('Unifi autorización error: ' . $e->getMessage());
        }

        return $this->redirigirInternet($request->input('url_origen'));
    }

    private function redirigirInternet(string $url)
    {
        $destino = filter_var($url, FILTER_VALIDATE_URL) ? $url : 'http://www.google.com';
        return redirect()->away($destino);
    }
}

<?php

use App\Http\Livewire\Mesas;
use App\Http\Livewire\Comanda;
use App\Http\Livewire\Menu;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BienvenidaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Menú público — sin autenticación
Route::get('/menu', Menu::class)->name('menu');

// Portal cautivo
Route::get('/bienvenida', [BienvenidaController::class, 'show'])->name('bienvenida');
Route::post('/bienvenida/autorizar', [BienvenidaController::class, 'autorizar'])->name('bienvenida.autorizar');

// Cartelito imprimible
Route::get('/cartelito', function () {
    return view('cartelito', [
        'ssid'      => config('unifi.wifi_ssid'),
        'password'  => config('unifi.wifi_password'),
        'url_menu'  => url('/bienvenida'),
    ]);
})->name('cartelito');

// Imágenes de RESOL
Route::get('/resol-img/{filename}', function (string $filename) {
    $path = config('resol.img_path') . DIRECTORY_SEPARATOR . basename($filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('resol.img')->where('filename', '[^/]+');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth:web,admin'])
    ->name('logout');

// Rutas de meseros
Route::middleware(['auth:web'])->group(function () {
    Route::get('/mesas', Mesas::class)->name('mesas');
    Route::get('/comanda/{mesa}', Comanda::class)->name('comanda');
});

// Rutas de administración / facturación
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

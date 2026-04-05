<?php


use App\Http\Livewire\Categories;
use App\Http\Livewire\Customers;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Products;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Reports;
use App\Http\Livewire\Sales;
use App\Http\Livewire\Settings;
use App\Http\Livewire\Users;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('categories', Categories::class)->name('categories');
    Route::get('products', Products::class);
    Route::get('customers', Customers::class);
    Route::get('users', Users::class);
    Route::get('sales', Sales::class);
    Route::get('reports', Reports::class);
    Route::get('profile', Profile::class)->name('profile');
    Route::get('dash', Dashboard::class)->name('dash');
    Route::get('settings', Settings::class)->name('dash');
});

Route::get('/', function () {
    return view('auth.login');
});


require __DIR__ . '/auth.php';

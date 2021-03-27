<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ComprasController;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect('admin');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    // Inventario
    Route::get('inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::get('inventario/create', [InventarioController::class, 'create'])->name('inventario.add');
    Route::post('inventario/store', [InventarioController::class, 'store'])->name('inventario.store');

    // Compras
    Route::get('compras', [ComprasController::class, 'index'])->name('compras.index');
    Route::get('compras/create', [ComprasController::class, 'create'])->name('compras.add');
    Route::post('compras/store', [ComprasController::class, 'store'])->name('compras.store');
});

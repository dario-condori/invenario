<?php

use App\Http\Controllers\Admin\ComercioController;
use App\Http\Controllers\Admin\InicioController;
use App\Http\Controllers\Admin\VehiculoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProformaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function(){
    Route::get('/admin/dashboard', [InicioController::class, 'dashboard'])->name('admin.dashboard');
});

//---Gestion de vehiculos
Route::middleware('auth')->group(function(){
    Route::get('/admin/vehiculos', [VehiculoController::class, 'vehiculos'])->name('admin.vehiculos');
    Route::get('/admin/vehiculos/nuevo', [VehiculoController::class, 'vehiculosNuevo'])->name('admin.vehiculos.nuevo');
    Route::post('/admin/vehiculos/guardar', [VehiculoController::class, 'vehiculosGuardar'])->name('admin.vehiculos.guardar');
    Route::get('/admin/combustible/{vehiculo}', [VehiculoController::class, 'vehiculosCombustible'])->name('admin.vehiculos.combustible');
    Route::post('/admin/combustible/cargar', [VehiculoController::class, 'combustibleCargar'])->name('admin.combustible.cargar');
});

//---Gestion de proforma
Route::middleware('auth')->group(function(){
    Route::get('/proforma', [ProformaController::class, 'listado'])->name('proforma.listado');
    Route::post('/proforma/guardar/cliente', [ProformaController::class, 'guardarCliente'])->name('proforma.guardar.cliente');
    Route::get('/proforma/generar/{id}', [ProformaController::class, 'generar'])->name('proforma.generar');
    Route::get('/proforma/generar/pdf/{id}', [ProformaController::class, 'generarPdf'])->name('proforma.generar.pdf');
    Route::post('/proforma/guardar/producto', [ProformaController::class, 'guardarProducto'])->name('proforma.guardar.producto');
});

//---Administración de comercialización
Route::middleware('auth')->group(function(){
    Route::get('/comercio', [ComercioController::class, 'listado'])->name('comercio.listado');
    Route::get('/comercio/seleccionar/vehiculo', [ComercioController::class, 'seleccionarVehiculo'])->name('comercio.seleccionarVehiculo');
    Route::get('/comercio/operacion/{vehiculo}', [ComercioController::class, 'operacion'])->name('comercio.operacion');
    Route::post('/comercio/operacion/guardar', [ComercioController::class, 'operacionGuardar'])->name('comercio.operacion.guardar');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

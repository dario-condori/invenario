<?php

use App\Http\Controllers\Admin\ComercioController;
use App\Http\Controllers\Admin\InicioController;
use App\Http\Controllers\Admin\VehiculoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProformaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('welcome');
    return to_route('admin.dashboard',['fecha_comercio'=>date('Y-m-d')]);
});

Route::middleware('auth')->group(function(){
    Route::get('/admin/dashboard/{fecha_comercio}', [InicioController::class, 'dashboard'])->name('admin.dashboard');
});

//---Gestion de vehiculos
Route::middleware('auth')->group(function(){
    Route::get('/admin/vehiculos', [VehiculoController::class, 'vehiculos'])->name('admin.vehiculos');
    Route::get('/admin/vehiculos/nuevo', [VehiculoController::class, 'vehiculosNuevo'])->name('admin.vehiculos.nuevo');
    Route::post('/admin/vehiculos/guardar', [VehiculoController::class, 'vehiculosGuardar'])->name('admin.vehiculos.guardar');
    Route::get('/admin/combustible/{vehiculo}', [VehiculoController::class, 'vehiculosCombustible'])->name('admin.vehiculos.combustible');
    Route::post('/admin/combustible/cargar', [VehiculoController::class, 'combustibleCargar'])->name('admin.combustible.cargar');
    Route::post('/admin/combustible/historial', [VehiculoController::class, 'vehiculosCombustibleHistorial'])->name('admin.vehiculos.historial');
    Route::get('/admin/vehiculos/mantenimiento/{vehiculo}', [VehiculoController::class, 'vehiculoMantenimiento'])->name('admin.vehiculos.mantenimiento');
    Route::post('/admin/vehiculos/datos', [VehiculoController::class, 'datosVehiculo'])->name('admin.vehiculos.datos');
    Route::post('/admin/vehiculos/mantenimiento/guardar', [VehiculoController::class, 'mantenimientoGuardar'])->name('admin.vehiculos.mantenimiento.guardar');
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
    Route::get('/comercio/{fecha_comercio}', [ComercioController::class, 'listado'])->name('comercio.listado');
    Route::get('/comercio/seleccionar/vehiculo', [ComercioController::class, 'seleccionarVehiculo'])->name('comercio.seleccionarVehiculo');
    Route::get('/comercio/operacion/{vehiculo}', [ComercioController::class, 'operacion'])->name('comercio.operacion');
    Route::post('/comercio/operacion/guardar', [ComercioController::class, 'operacionGuardar'])->name('comercio.operacion.guardar');
    Route::post('/comercio/combustible/vehiculo', [ComercioController::class, 'combustibleVehiculo'])->name('comercio.operacion.combustible');
    Route::get('/comercio/operacion/productos/{comercio}', [ComercioController::class, 'comercioProductos'])->name('comercio.operacion.productos');
    Route::post('/comercio/operacion/productos/guardar', [ComercioController::class, 'comercioProductoGuardar'])->name('comercio.operacion.producto.guardar');
    Route::delete('/comercio/operacion/productos/eliminar', [ComercioController::class, 'comercioProductoEliminar'])->name('comercio.operacion.producto.eliminar');
    Route::post('/comercio/operacion/productos/edit', [ComercioController::class, 'comercioProductoEdit'])->name('comercio.operacion.producto.edit');
    Route::post('/comercio/operacion/productos/actualizar', [ComercioController::class, 'comercioProductoActualizar'])->name('comercio.operacion.producto.actualizar');
    Route::get('/comercio/operacion/pdf/{fecha_comercio}', [ComercioController::class, 'comercioPdf'])->name('comercio.operacion.pdf');
    Route::get('/comercio/reporte/semanal/{fecha_comercio}', [ComercioController::class, 'reporteSemanal'])->name('comercio.reporte.semanal');
    Route::delete('/comercio/operacion/eliminar', [ComercioController::class, 'comercioOperacionEliminar'])->name('comercio.operacion.eliminar');
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

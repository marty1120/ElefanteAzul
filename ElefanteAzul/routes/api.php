<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CitasController;
use App\Http\Controllers\Api\TipoLavadoController;

Route::get('/citas', [CitasController::class, 'index'])->name('api.citas.index');
Route::post('/citas', [CitasController::class, 'store'])->name('api.citas.store');

Route::get('/tipo_lavado', [TipoLavadoController::class, 'index'])->name('api.tipo_lavado.index');
Route::post('/tipo_lavado/verificar', [TipoLavadoController::class, 'verificarDescripcion'])->name('api.tipo_lavado.verificar');
Route::post('/tipo_lavado', [TipoLavadoController::class, 'store'])->name('api.tipo_lavado.store');
Route::delete('/tipo_lavado/{id}', [TipoLavadoController::class, 'destroy'])->name('api.tipo_lavado.destroy');
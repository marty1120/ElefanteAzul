<?php
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\TipoLavadoController;
use App\Http\Controllers\Api\TipoLavadoController as ApiTipoLavadoController;
use App\Http\Controllers\UsuariosController;

// Rutas para la interfaz de usuario
Route::get('/tipo_lavado', [TipoLavadoController::class, 'index'])->name('tipo_lavado.index');
Route::get('/tipo_lavado/crear', [TipoLavadoController::class, 'create'])->name('tipo_lavado.create');
Route::post('/tipo_lavado', [TipoLavadoController::class, 'store'])->name('tipo_lavado.store');

// Rutas para la API
Route::get('/api/tipo_lavado', [ApiTipoLavadoController::class, 'index'])->name('api.tipo_lavado.index');
Route::post('/api/tipo_lavado/verificar', [ApiTipoLavadoController::class, 'verificarDescripcion'])->name('api.tipo_lavado.verificar');
Route::post('/api/tipo_lavado', [ApiTipoLavadoController::class, 'store'])->name('api.tipo_lavado.store');
Route::delete('/api/tipo_lavado/{id}', [ApiTipoLavadoController::class, 'destroy'])->name('api.tipo_lavado.destroy');

// Google
Route::get('/google/login', [GoogleController::class, 'login'])->name('google.login');
Route::get('/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Usuarios
Route::get('/usuarios/login', [UsuariosController::class, 'login'])->name('usuarios.login');
Route::post('/usuarios/authenticate', [UsuariosController::class, 'authenticate'])->name('usuarios.authenticate');
Route::post('/usuarios/logout', [UsuariosController::class, 'logout'])->name('usuarios.logout');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas/create', [CitasController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
});


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReporteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::apiResource('proveedores', ProveedorController::class);
//Route::apiResource('roles', RolController::class);
//Route::apiResource('users', UserController::class);
//Route::apiResource('evaluaciones', EvaluacionController::class);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/reportes/evaluacion/{id}/pdf', [ReporteController::class, 'generarPDF']);
Route::get('/reportes/evaluacion/{id}/excel', [ReporteController::class, 'generarExcel']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas accesibles para administradores (rol_id = 1)
    Route::middleware('role:1')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RolController::class);
    });

    // Rutas accesibles para evaluadores (rol_id = 2)
    Route::middleware('role:1,2,3')->group(function () {
        Route::apiResource('evaluaciones', EvaluacionController::class);

    });

    // Rutas accesibles para supervisores (rol_id = 3)
    Route::middleware('role:1,2,3')->group(function () {
        Route::apiResource('proveedores', ProveedorController::class);
    });
});


<?php

use App\Http\Controllers\api\CamposController;
use App\Http\Controllers\api\ColeccionController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});


Route::controller(CamposController::class)->group(function () {
    Route::get('campos', [CamposController::class, 'index']);
    Route::get('campos/{id}', [CamposController::class, 'show']);
    Route::post('campos', [CamposController::class, 'store']);
    Route::put('campos/{id}', [CamposController::class, 'update']);
    Route::delete('campos/{id}', [CamposController::class, 'destroy']);
    Route::post('campos/agregar-subcampo', [CamposController::class, 'agregarSubcampo']);
    Route::post('campos/quitar-subcampo', [CamposController::class, 'quitarSubcampo']);
    Route::get('subcampos/{id}', [CamposController::class, 'listarSubcampos']);
});


Route::get('colecciones', [ColeccionController::class, 'index']);
Route::get('colecciones/{id}', [ColeccionController::class, 'show']);
Route::post('colecciones', [ColeccionController::class, 'store']);

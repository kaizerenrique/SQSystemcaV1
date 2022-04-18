<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

// Ruta de Informacion del usuario
Route::post('/infouser',[ApiController::class,'infouser'])->middleware('auth:sanctum');

Route::get('/listadousuarios',[ApiController::class,'listadousuarios'])->middleware('auth:sanctum');

Route::get('/listadolaboratorios',[ApiController::class,'listadolaboratorios'])->middleware('auth:sanctum');

Route::get('/listadoPerfiles',[ApiController::class,'listadoPerfiles'])->middleware('auth:sanctum');

Route::get('/perfilinfo/{code}',[ApiController::class,'perfilinfo'])->middleware('auth:sanctum');

Route::get('/cedulaInfo/{cedula}',[ApiController::class,'cedulaInfo'])->middleware('auth:sanctum');

Route::post('documento',[ApiController::class,'documento'])->middleware('auth:sanctum');

Route::get('/generadorDeEnlaces',[ApiController::class,'generadorDeEnlaces'])->middleware('auth:sanctum');

Route::get('/cedulaInfo/{cedula}',[ApiController::class,'cedulaInfo'])->middleware('auth:sanctum');

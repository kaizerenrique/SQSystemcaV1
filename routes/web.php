<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Mail\mailRegistroLaboratorio;
use App\Models\Historial;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/usuarios', function () {
    return view('usuarios');
})->name('usuarios');

Route::middleware(['auth:sanctum', 'verified'])->get('/personas', function () {
    return view('personas');
})->name('personas');

//ruta para documentos
Route::get('/documentos/{url_code}', function ($url_code) {
    $respuesta = Historial::where("url_code", $url_code)->first();
    $name = $respuesta->nombreArchivo;
    $url_documento = $respuesta->url_documento;    
    return response()->file(storage_path($url_documento. $name));    
});
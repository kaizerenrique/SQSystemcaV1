<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Mail\mailRegistroLaboratorio;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DocumentosController;

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
})->name('welcome');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/usuarios', function () {
    return view('usuarios');
})->name('usuarios');

Route::middleware(['auth:sanctum', 'verified'])->get('/personas', function () {
    return view('personas');
})->name('personas');

Route::middleware(['auth:sanctum', 'verified'])->get('/configuracion', function () {
    return view('configuracion');
})->name('configuracion');

Route::middleware(['auth:sanctum', 'verified'])->get('/estadistica', function () {
    return view('estadistica');
})->name('estadistica');

Route::get('/documentos/{url_code}', [DocumentosController::class, 'show']);

Route::get('/consulta', [ConsultaController::class, 'index'])->name('consulta');

Route::post('/consulta', [ConsultaController::class, 'show'])->name('consulta.show');

Route::get('/consulta/{nombreDocumento}', [ConsultaController::class, 'verDocumento'])->name('consulta.verDocumento');

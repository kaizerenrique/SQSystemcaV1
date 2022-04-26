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

Route::middleware(['auth:sanctum', 'verified'])->get('/configuracion', function () {
    return view('configuracion');
})->name('configuracion');

Route::middleware(['auth:sanctum', 'verified'])->get('/estadistica', function () {
    return view('estadistica');
})->name('estadistica');

//ruta para documentos
Route::get('/documentos/{url_code}', function ($url_code) {

    if (Historial::where("url_code", $url_code)->exists()) {
        $respuesta = Historial::where("url_code", $url_code)->first();    
        $url_documento = $respuesta->url_documento;
        return Redirect::to($url_documento); 
    }else{
        return view('welcome');
    }
          
});

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;

class DocumentosController extends Controller
{
    
    public function index()
    {
        return view('welcome');
    }

    
    public function show($url_code)
    {
        if (Historial::where("url_code", $url_code)->exists()) {
            $respuesta = Historial::where("url_code", $url_code)->first();
            $url = $respuesta->url_documento;
            return view('consultaCedula.verDocumento',['url' => $url]);
            
            //$url_documento = $respuesta->url_documento;
            //return redirect($url_documento);
        }else{
            return view('error.subir-documento');
        }
    }
    
}

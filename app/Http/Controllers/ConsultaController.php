<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Historial;
use Illuminate\Support\Facades\Storage;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('consultaCedula.index');
    }

    
    public function show(Request $request)
    {
        $request->validate([
            'cedula' => 'required',
        ]);

        $info = $request->cedula;

        if (Historial::where('cedula', $info)->exists()) {
                //$respuesta = Historial::where('cedula', $info)->first();    
                //$url_documento = $respuesta->url_documento;
                //return redirect($url_documento);
            $historials = Historial::where('cedula', $info)
                ->orderBy('id','desc')
                ->paginate(5);
            $persona = Historial::where('cedula', $info)->first();
            $nombre = $persona->nombreyapellido;
            $cedula = $persona->cedula;   
            return view('consultaCedula.resultados',['historials' => $historials,'nombre' => $nombre,'cedula' => $cedula]);
        }else{
            $mensaje = 'No se ha encontrado documento asociado al número de cédula: '.$info;
            return view('consultaCedula.show',['info' => $mensaje]);
        }
        
    }

    public function verDocumento($nombreDocumento)
    {
        if (Historial::where('nombreArchivo', $nombreDocumento)->exists()) {            
            $url = 'http://ditecp.xyz/storage/'.$nombreDocumento;            
            return view('consultaCedula.verDocumento',['url' => $url]);
        }  
    }
    
}

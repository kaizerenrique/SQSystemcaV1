<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Historial;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            'cedula' => 'required',
        ]);

        $info = $request->cedula;
        if (Persona::where('cedula', $info)->exists()) {            
            if (Historial::where('cedula', $info)->exists()) {
                $respuesta = Historial::where('cedula', $info)->first();    
                $url_documento = $respuesta->url_documento;
                return redirect($url_documento);
            }else{
                $mensaje = 'El número de cédula '.$info.' está asociado a un perfil pero no posee documentos cargados en el sistema.';
                return view('consultaCedula.show',['info' => $mensaje]);
            }
        }else {            
            $mensaje = 'No se ha encontrado documento asociado al número de cédula: '.$info;
            return view('consultaCedula.show',['info' => $mensaje]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

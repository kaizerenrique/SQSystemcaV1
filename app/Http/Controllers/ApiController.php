<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use App\Models\Persona;
use App\Models\Historial;

class ApiController extends Controller
{
    //Retorna informacion del usuario
    public function infouser(Request $request)
    {
        $respuesta = $request->user();
        $respuesta->getRoleNames();

        //Respuesta
        return response([
            "status" => 200,
            "ms" => "Información del usuario",
            "data" => $respuesta,
        ]);
    }

    //Retorna un Listado de Todos los Usuarios
    public function listadousuarios()
    {
        
        $usuarios = User::role('Usuario')->get();

        //Respuesta
        return response([
            "status" => 200,
            "ms" => "Listado de Usuarios",
            "data" => $usuarios
        ]);
    }

    //Retorna un Listado de Laboratorios
    public function listadolaboratorios()
    {
        //$usuarios = User::all();
        $usuarios = User::role('Laboratorio')->get();

        //Respuesta
        return response([
            "status" => 200,
            "ms" => "Listado de Laboratorios",
            "data" => $usuarios
        ]);
    }

    //Listado de Perfiles de usuarios
    public function listadoPerfiles()
    {
        $listado = Persona::all();

        //Respuesta
        return response([
            "status" => 200,
            "ms" => "Listado de Perfiles de Usuarios",
            "data" => $listado
        ]);
    }

    //Buscar usuario por codigo
    public function perfilinfo($code)
    { 
        if (Persona::where('idusuario', $code)->exists()) {
            $respuesta = Persona::where("idusuario", $code)->get();

            //Respuesta
            return response([
                "status" => 200,
                "ms" => "Perfile de Usuario",
                "data" => $respuesta
            ]);
        }else{

            //Respuesta
            return response([
                "status" => 1,
                "ms" => "Perfile de Usuario",
                "data" => "Codigo no Registrada"
            ]);
        }  
    }

    //Buscar usuario por numero de cedula
    public function cedulaInfo($cedula)
    {   
        if (Persona::where('cedula', $cedula)->exists()) {
            $respuesta = Persona::where("cedula", $cedula)->get();

            //Respuesta
            return response([
                "status" => 200,
                "ms" => "Perfile de Usuario",
                "data" => $respuesta
            ]);
        }else{

            //Respuesta
            return response([
                "status" => 1,
                "ms" => "Perfile de Usuario",
                "data" => "Cedula no Registrada"
            ]);
        } 
    }

    //esta funcion genera url simbolicas para el sistema qr
    public function generadorDeEnlaces(){
        
        do {
            $dinamicoUrl = Str::random(21);

            //$url_sistema = env('APP_URL');
            $url_sistema = 'http://ditecp.xyz';
            $url_simbol = $url_sistema . '/documentos/' . $dinamicoUrl;

        } while (Historial::where('url_simbol', $dinamicoUrl)->exists());
            
            return response([
                "status" => 200,
                "ms" => "Url Simbolico",
                "url" => $url_simbol,
                "codeUrl" => $dinamicoUrl
            ]);        
    }

    //Guarda el Documento
    public function documento(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $filename = pathinfo($filename, PATHINFO_FILENAME);
            $name_File = str_replace(" ", "_", $filename);
            $extension = $file->getClientOriginalExtension();
            $picture = date('His').'_'.$name_File.'.'.$extension;

            if (Historial::where('url_simbol', $request->url_simbol)->exists()) {
                //Respuesta
                return response([
                    "status" => 1,
                    "ms" => "Error de URL Simbolico",
                ]);
            }else {
                $code = $request->code;
                $persona_id = $request->persona_id;
                $url_simbol = $request->url_simbol;
                $url_code = $request->url_code;
                $nombreArchivo = $picture;
                $user = $request->user();


                $path = $request->file('file')->storeAs(
                    'public/documentos/'. $code, $picture
                );
                
                $url_documento = 'app/public/documentos/'. $code. '/' ; 

                $historial = Historial::create([ 
                    'persona_id' => $persona_id,           
                    'codigo' => $code,
                    'nombreArchivo' => $picture,
                    'url_simbol' => $url_simbol,
                    'url_code' => $url_code,
                    'url_documento' => $url_documento,
                    'user_id' => $user->id,
                    'nombreLaboratorio' => $user->name
                ]);

                //Respuesta
                return response([
                    "status" => 200,
                    "ms" => "Exitoso",
                    "data" => $historial
                ]);
            }            

        } else {

            //Respuesta
            return response([
                "status" => 1,
                "ms" => "Error de archivo",
            ]);
        }          
    }

    
}

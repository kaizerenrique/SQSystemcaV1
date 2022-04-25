<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
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
                "status" => 500,
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
                "status" => 500,
                "ms" => "Perfile de Usuario",
                "data" => "Cedula no Registrada"
            ]);
        } 
    }

    //esta funcion genera url simbolicas para el sistema qr
    public function generadorDeEnlaces()
    {
        
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

    //funcion para subir documentos
    public function doc(Request $request)
    {
        if (Historial::where('url_simbol', $request->url_simbol)->exists()) {
            //Respuesta
            return response([
                "status" => 500,
                "ms" => "Error de URL Simbolico",
            ]);
        }else {
            $image_64 = $request['file'];
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',')+1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);            

            //generar nombre de forma randon y confirmar que no se repite
            do {
                $imageName = Str::random(10).'.'.$extension;
            } while (Historial::where('nombreArchivo', $imageName )->exists());
            
            $code = $request->code;
            $persona_id = $request->persona_id;
            $url_simbol = $request->url_simbol;
            $url_code = $request->url_code;
            $user = $request->user();

            Storage::disk('public')->put($imageName, base64_decode($image));

            $url_documento = Storage::disk('public')->url($imageName);

            $historial = Historial::create([ 
                'persona_id' => $persona_id,           
                'codigo' => $code,
                'nombreArchivo' => $imageName,
                'url_simbol' => $url_simbol,
                'url_code' => $url_code,
                'url_documento' => $url_documento,
                'user_id' => $user->id,
                'nombreLaboratorio' => $user->name
            ]);        

            return response([
                "status" => 200,
                "ms" => "Exitoso",
                "data" => $historial
            ]);
        }
    } 

    //funcion para generar codigo
    public function generarCodigoNuevo()
    {
        // generar codigo de  7 digitos y comprobar que no se repita
        do {
            $code = Str::random(7);    
        } while (Persona::where('idusuario', $code)->exists());

        return response([
            "status" => 200,
            "ms" => "Exitoso",
            "data" => $code
        ]);
    }

    public function generarTokenMenorSinCedula()
    {
        //generar identificador para menor de edad sin cedula
        do {
            $numero_aleatorio = rand(1,9999999);
            $msc = 'MSC-'.$numero_aleatorio;    
        } while (Persona::where('cedula', $msc)->exists());

        return response([
            "status" => 200,
            "ms" => "Exitoso",
            "data" => $msc
        ]);
    }

}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Persona;
use App\Models\Historial;
use Illuminate\Support\Str;
use Mail;
use App\Mail\notificacion;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


class Personas extends Component
{
    use WithPagination;

    public $cedula;
    public $nac;
    public $nombre;
    public $apellido;
    public $pasaporte;
    public $fnacimiento;
    public $sexo;
    public $nrotelefono;
    public $direccion;
    public $mensaje;
    public $codigo;
    public $resultado;
    public $idDoc;
    public $titulo;
    public $modalCedula = false;
    public $mostrarResulCedula = false;
    public $mensajeModal = false;
    public $confirmingPersonaAdd = false;
    public $codigoModal = false;
    public $eliminaDocAlerta = false;
    public $eliminado = false;
    public $eliminaPerfilAlerta = false;
    public $mensajeModalMenor = false;
    public $registroModalMenor = false;
   
    public function render()
    {
        $personas = Persona::where('user_id', auth()->user()->id)->get();

        $historials = Historial::where('persona_id', auth()->user()->id)
            ->orderBy('id','desc')
            ->paginate(5);

        return view('livewire.personas',[
            'personas' => $personas,
            'historials' => $historials,
        ]);
    }

    public function agregarPerfil()
    {
        //consultar el numero de registros que tiene el usuario
        $num =  Persona::where('user_id', auth()->user()->id)->count();
        //establecer un limite para los registros
        $config = Configuracion::first();
        $lin = $config->max_personas;

        //si el limite a sido alcanzado se procede a enviar un mensaje notificando que el limite fue alcanzado
        //de lo contrario se procede con el registro
        if ($num == $lin) {
            $mensaje = 'A alcanzado el numero limite de registros disponibles para su cuenta';
            $this->mensaje = $mensaje;
            $this->mensajeModal = true; 
        } else {
            $this->reset(['cedula']);
            $this->modalCedula = true;
        }       
        
    }

    protected function rules()
    {
        if ($modalCedula = true) {
            return [
                'nac' => 'required',
                'cedula' => 'required|numeric|integer|digits_between:6,8',
            ];
        }        
    }

    //comprobamos is la cedula esta o no en la base de datos
    public function comprobarCedula()
    { 

       $this->validate();

        $nac = $this->nac;
        $cedula = $this->cedula;

        //evaluamos si la cedula existe registrada
        if (Persona::where('cedula', $cedula)->exists()) {
            $this->modalCedula = false;
            //SI ya esta registrada enviamos un modal informando que la cedula ya esta registrada en la base de datos            
            $mensaje = 'EL Numero de Cedula: '.$nac.$cedula.' ya se encuentra Registrado.';
            $this->mensaje = $mensaje;
            $this->mensajeModal = true;            
        } elseif (Persona::where('cedula', $cedula)->exists() == null) {
            $this->modalCedula = false;

            $this->nac = $nac;
            $this->cedula = $cedula;
            $this->reset(['nombre']);
            $this->reset(['apellido']);
            $this->reset(['pasaporte']);
            $this->reset(['fnacimiento']);
            $this->reset(['nrotelefono']);
            $this->reset(['direccion']);
            $this->confirmingPersonaAdd = true;
        } else {
            //Si la Cedula Aun no esta registrada
            //Y no esta en el CNE se desplieaga el formulario de registro
            $this->modalCedula = false;
            $this->cedula = $cedula;
            $this->confirmingPersonaAdd = true;
        }
    }

    public function savePersona()
    {
        //validar
        $this->validate([
            'nombre' => 'required|string|min:3',
            'apellido' => 'required|string|min:4',
            'nac' => 'required',
            'cedula' => 'required|numeric|integer|digits_between:6,8',
            'pasaporte' => 'nullable|string|min:4',
            'fnacimiento' => 'before:date',
            'sexo' => 'required|in:Femenino,Masculino',
            'nrotelefono' => 'nullable|string|min:12|max:15',
            'direccion' => 'required|string|min:8|max:200',
        ]);
        
        
        // generar codigo de  7 digitos y comprobar que no se repita
        do {
            $code = Str::random(7);    
        } while (Persona::where('idusuario', $code)->exists());

        //guardar perfil            
        auth()->user()->personas()->create([ 
            'idusuario' => $code,           
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'nac' => $this->nac,
            'cedula' => $this->cedula,
            'sexo' => $this->sexo,
            'pasaporte' => $this->pasaporte ?? null,
            'fnacimiento' => $this->fnacimiento,
            'nrotelefono' => $this->nrotelefono ?? null,
            'direccion' => $this->direccion,
        ]);
        
        $this->confirmingPersonaAdd = false;

        //funcion que envia el correo
        $subject = 'Nuevo Registro';
        $mensajeCorreo = 'El registro se a realizado correctamente';
        $nombre = $this->nombre;
        $apellido = $this->apellido;
        $cedula = $this->cedula;
        $email = auth()->user()->email;
        Mail::to($email)->send(new notificacion($subject, $mensajeCorreo, $nombre, $apellido, $cedula, $code));

        $mensaje = 'Se a realizado el registro de forma correcta.';
        $this->mensaje = $mensaje;
        $this->mensajeModal = true; 
    }

    //Muestra el codigo del perfil
    public function mostrarCodigo($id)
    {
        $resul = Persona::find($id);
        $this->codigo = $resul->idusuario;
        $this->codigoModal = true;
    }

    public function consulBorrarDocumento($id)
    {
        $resul = Historial::find($id);
        $this->titulo = 'Alerta !!';
        $this->resultado = 'Esta seguro de querer eliminar el documento '. $resul->nombreArchivo . 'una vez eliminado no podrá ser recuperado';
        $this->idDoc = $resul->id;
        $this->eliminaDocAlerta = true;
    }

    public function BorrarDocumento($id)
    {
        $this->eliminaDocAlerta = false;
        $resul = Historial::find($id);
        Storage::disk('public')->delete($resul->nombreArchivo);
        $resul->delete();
        $this->titulo = 'Borrado';
        $this->resultado = 'El documento a sido borrado exitosamente';
        $this->eliminado = true;
    }

    public function consulBorrarPerfil($id)
    {
        $resul = Persona::find($id);

        $this->titulo = 'Alerta !!';
        $this->resultado = 'Esta seguro de querer eliminar el perfil '. $resul->nombre .' '. $resul->apellido. ' una vez eliminado no podrá ser recuperado';
        $this->idDoc = $resul->id;
        $this->eliminaPerfilAlerta = true;
    }

    public function BorrarPersona($id)
    {
        $this->eliminaPerfilAlerta = false;

        $resul = Persona::find($id);

        //obtener listado de documentos
        $documentos = Historial::where('codigo', $resul->idusuario)->get();

        //almacenar documentos en un array
        $array_de_archivos = [];
        foreach($documentos as $documento) {
            $array_de_archivos[] = $documento->nombreArchivo;
        }
        //eliminar documentos del servidos
        Storage::disk('public')->delete($array_de_archivos);
        //eliminar historial 
        Historial::where('codigo', $resul->idusuario )->delete();

        //funcion que envia el correo
        $subject = 'Eliminar Registro';
        $mensajeCorreo = 'El perfil a sido Eliminado Correctamente';
        $nombre = $resul->nombre;
        $apellido = $resul->apellido;
        $cedula = $resul->cedula;
        $code = $resul->idusuario;
        $email = auth()->user()->email; // usuario autenticado
        Mail::to($email)->send(new notificacion($subject, $mensajeCorreo, $nombre, $apellido, $cedula, $code));

        //Eliminar perfil de persona 
        $resul->delete();

        $this->titulo = 'Perfil Eliminado';
        $this->resultado = 'El perfil a sido Eliminado Correctamente';
        $this->eliminado = true;
    }

    //Agregar menores de Edad sin Cedula
    public function menorSinCedula()
    {
        //consultar el numero de registros que tiene el usuario
        $num =  Persona::where('user_id', auth()->user()->id)->count();
        //establecer un limite para los registros
        $config = Configuracion::first();
        $lin = $config->max_personas;

        //si el limite a sido alcanzado se procede a enviar un mensaje notificando que el limite fue alcanzado
        //de lo contrario se procede con el registro
        if ($num == $lin) {
            $mensaje = 'A alcanzado el numero limite de registros disponibles para su cuenta';
            $this->mensaje = $mensaje;
            $this->mensajeModal = true; 
        } else {    
            $this->titulo = 'Información';
            $this->mensaje = 'El sistema asignara un numero de identificación para el menor de edad. 
            Una vez el menor tenga su Cedula de Identidad podrá cambiar este identificador por su numero de cedula.';
            $this->mensajeModalMenor = true; 
        }  
    }

    public function agregarMenorSinCedula()
    {
        $this->mensajeModalMenor = false;

        $this->reset(['nombre']);
        $this->reset(['apellido']);
        $this->reset(['fnacimiento']);
        $this->reset(['nrotelefono']);
        $this->reset(['direccion']);
        $this->registroModalMenor = true;
    }

    public function saveMenorSinCedula()
    {
        //validar
        $this->validate([
            'nombre' => 'required|string|min:3',
            'apellido' => 'required|string|min:4',
            'fnacimiento' => 'before:date',
            'sexo' => 'required|in:Femenino,Masculino',
            'direccion' => 'required|string|min:8|max:200',
        ]);


        
        // generar codigo de  7 digitos y comprobar que no se repita
        do {
            $code = Str::random(7);    
        } while (Persona::where('idusuario', $code)->exists());

        //generar identificador para menor de edad sin cedula
        $nac = 'V';
        do {
            $numero_aleatorio = rand(1,9999999);
            $msc = 'MSC-'.$numero_aleatorio;    
        } while (Persona::where('cedula', $msc)->exists());

        //guardar perfil            
        auth()->user()->personas()->create([ 
            'idusuario' => $code,           
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'nac' => $nac,
            'cedula' => $msc,
            'sexo' => $this->sexo,
            'pasaporte' => $this->pasaporte ?? null,
            'fnacimiento' => $this->fnacimiento,
            'nrotelefono' => $this->nrotelefono ?? null,
            'direccion' => $this->direccion,
        ]);
        
        $this->registroModalMenor = false;

        //funcion que envia el correo
        $subject = 'Se a registrado un Menor sin Cedula ';
        $mensajeCorreo = 'El registro se a realizado correctamente';
        $nombre = $this->nombre;
        $apellido = $this->apellido;
        $cedula = $msc;
        $email = auth()->user()->email;
        Mail::to($email)->send(new notificacion($subject, $mensajeCorreo, $nombre, $apellido, $cedula, $code));

        
        $this->mensaje = 'Se a realizado el registro de forma correcta.';
        $this->mensajeModal = true; 


    }
    
}

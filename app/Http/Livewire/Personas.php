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
    public $modalCedula = false;
    public $mostrarResulCedula = false;
    public $mensajeModal = false;
    public $confirmingPersonaAdd = false;
    public $codigoModal = false;
   
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
    //comprobamos si la cedula esta registrada en el CNE
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
            //Si el usuario esta registrado en el CNE tomamos su nombre para colocar en el formulario
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
            'fnacimiento' => 'date',
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
        $nombre = $this->nombre;
        $apellido = $this->apellido;
        $cedula = $this->cedula;
        $email = auth()->user()->email;
        Mail::to($email)->send(new notificacion($subject, $nombre, $apellido, $cedula, $code));

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
    
}

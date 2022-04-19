<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\mailRegistroLaboratorio;
use Illuminate\Support\Str;
use App\Models\Configuracion;

class Usuarios extends Component
{

    use WithPagination;

    public $buscar;
    public $usuario;    
    public $confirmingPersonaVer = false;
    public $confirmingPersonaEditar = false;
    public $agregarLaboratorio = false;
    public $mostrarTokenApi = false;

    public $name;
    public $email;

    protected $queryString = [
        'buscar' => ['except' => '']
    ];

    public function render()
    {
        //listar los usuarios y consultar por nombre y correo
        $usuarios = User::where('name', 'like', '%'.$this->buscar . '%')  //buscar por nombre de usuario
                      ->orWhere('email', 'like', '%'.$this->buscar . '%') //buscar por correo de usuario
                      ->orderBy('id','desc') //ordenar de forma decendente
                      ->paginate(10); //paginacion

        $roles = Role::all();
        //Numero de Usuarios Totales
        $users_count = User::count();

        return view('livewire.usuarios',[
            'usuarios' => $usuarios,
            'roles' => $roles,
            'users_count' => $users_count
        ]);
    }

    //Actualizar tabla para corregir falla de busqueda
    public function updatingBuscar()
    {
        $this->resetPage();
    }

    //Ver datos de registro
    public function confirmPersonaVer($id)
    {        
        //$this->usuario = $usuario;
        $usuario = User::find($id);
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->fechaReg = $usuario->created_at;
        $this->rol = $usuario->getRoleNames();
        $this->confirmingPersonaVer = true;
    }

    public function confirmPersonaEditar($id)
    {
        $usuario = User::find($id);
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->fechaReg = $usuario->created_at;
        $this->rol = $usuario->getRoleNames();
        $this->confirmingPersonaEditar = true;
    }

    //Registro de Laboratorio
    public function laboratorioAdd()
    {
        $this->reset(['name']);
        $this->reset(['email']);
        $this->agregarLaboratorio = true;
    }

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email|unique:users',
    ];

    public function guardarLaboratorio()
    {
        $this->validate();

        //genera una contraseña de 8 caracteres de forma randon
        $password = Str::random(8);

        $laboratorio = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($password),
        ])->assignRole('Laboratorio');


        //Generar Token de API
        $token = $laboratorio->createToken($laboratorio->name, ["read","create","update","delete"])->plainTextToken;

        //Envio de correos
        $name = $laboratorio->name;
        $email = $laboratorio->email;

        $config = Configuracion::first();
        $emailcopia = $config->email_system;
        //funcion que envia el correo
        Mail::to($email)->send(new mailRegistroLaboratorio($name, $email, $password, $token));
        //copia del correo para la administracion
        Mail::to($emailcopia)->send(new mailRegistroLaboratorio($name, $email, $password, $token));

        $this->agregarLaboratorio = false;

        //Mostrar Token Api del Laboratorio 
        $this->token = $token;
        $this->mostrarTokenApi = true;
        
    }
}

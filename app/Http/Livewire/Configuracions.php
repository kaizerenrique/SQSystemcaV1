<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Configuracion;
use App\Models\Persona;
use App\Models\Historial;
use App\Models\User;
use Spatie\Permission\Models\Role;

class Configuracions extends Component
{
    public $configuracion = false;
    public Configuracion $confi;    

    public function render()
    {   
        $config = Configuracion::first();

        $users_count = User::count(); //total de usuarios registrados
        $usuarios = User::role('Usuario')->count(); //usuarios normales
        $laboratorio = User::role('Laboratorio')->count(); //usuarios laboratorios
        $personas_count = Persona::count(); //perfiles 
        $historias_count = Historial::count(); //historias
        
        return view('livewire.configuracions',[
            'config' => $config,
            'users_count' => $users_count,
            'personas_count' => $personas_count,
            'historias_count' => $historias_count,
            'laboratorio' => $laboratorio,
            'usuarios' => $usuarios,
        ]);
    }

    protected $rules = [
        'confi.max_personas' => 'required|numeric|integer|digits_between:1,2|min:0|not_in:0',
        'confi.max_empresas' => 'required|numeric|integer|digits_between:1,3|min:0|not_in:0',
        'confi.email_system' => 'required|email'
    ];

    public function configuracionSistema(Configuracion $confi)
    {
        $this->confi = $confi;
        $this->configuracion = true;
    }

    public function maximoPerfilGuardar()
    {
        $this->validate();
        $this->confi->save();
        $this->configuracion = false;
    }
    
}

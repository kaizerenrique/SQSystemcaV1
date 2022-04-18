<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Configuracion;

class Configuracions extends Component
{
    public function render()
    {
        $config = Configuracion::first();
        //dd($config->max_personas);
        
        return view('livewire.configuracions',[
            'max_personas' => $config->max_personas,
            'max_empresas' => $config->max_empresas,
            'email_system' => $config->email_system,
        ]);
    }
}

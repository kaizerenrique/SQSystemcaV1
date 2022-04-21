<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Contacto;

class DatosContactos extends Component
{
    public function render()
    {
        $contacto = Contacto::first();
        return view('livewire.datos-contactos',[
            'contacto' => $contacto,
        ]);
    }
}

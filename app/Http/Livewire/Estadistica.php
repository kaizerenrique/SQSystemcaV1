<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Historial;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class Estadistica extends Component
{
    use WithPagination;

    public $buscar;

    protected $queryString = [
        'buscar' => ['except' => '']
    ];

    public function render()
    {
        //historias que a subido el laboratorio
        $historials = Historial::where('user_id', auth()->user()->id);
        
        $historials = $historials->Where('nombreyapellido', 'like', '%'.$this->buscar . '%')
            ->orWhere('cedula', 'like', '%'.$this->buscar . '%')
            ->orWhere('codigo', 'like', '%'.$this->buscar . '%')
            ->orderBy('id','desc');

        $historials = $historials->paginate(10);

        //numero de historias totales subidas
        $historiasTotales = Historial::where('user_id', auth()->user()->id)->count();

        $date = Carbon::now();// obtener fecha
        //obtener registros del dia de hoy
        $hoy = Historial::where('user_id', auth()->user()->id)
            ->whereDate('created_at', '=', $date)
            ->count();

        $ayer = Historial::where('user_id', auth()->user()->id)
            ->whereDate('created_at', '=', $date->subDay(1))
            ->count();

        return view('livewire.estadistica',[
            'historials' => $historials,
            'historiasTotales' => $historiasTotales,
            'hoy' => $hoy,
            'ayer' => $ayer,
        ]);
    }

    //Actualizar tabla para corregir falla de busqueda
    public function updatingBuscar()
    {
        $this->resetPage();
    }
}

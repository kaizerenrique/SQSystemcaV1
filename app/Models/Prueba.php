<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipoMoneda',
        'costo',
        'estatus',
    ];

    //laboratorio al que pertecece 
    public function laboratorio()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

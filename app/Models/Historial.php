<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;

class Historial extends Model
{
    use HasFactory;

    protected $fillable =['persona_id','codigo','nombreArchivo','url_simbol','url_code','url_documento','user_id','nombreLaboratorio'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}

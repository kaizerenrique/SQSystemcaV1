<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Historia;

class Persona extends Model
{
    use HasFactory;

    protected $fillable =['idusuario','nombre','apellido','nac','cedula','sexo','pasaporte','fnacimiento','nrotelefono','direccion'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function historias()
    {
        return $this->hasMany(Historial::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable =[
        'nombre',
        'rif',
        'telefono',
        'email',
        'direccion',
        'social_media1',
        'social_media2',
        'social_media3',
        'social_media4',
        'social_media5',
        'social_media6'
    ];
}


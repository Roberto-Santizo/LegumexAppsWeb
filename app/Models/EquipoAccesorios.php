<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipoAccesorios extends Model
{
    protected $fillable = [
        'equipo_id',
        'accesorio_id'
    ];
}

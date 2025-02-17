<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrabajoEquipo extends Model
{
    protected $casts = [
        'fecha_planificacion' => 'datetime',
        'fecha_realizacion' => 'datetime'
    ];

    protected $fillable = [
        'fecha_planificacion',
        'fecha_realizacion',
        'descripcion',
        'firma_responsable',
        'equipo_id'
    ];
}

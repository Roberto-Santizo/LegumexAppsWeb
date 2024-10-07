<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraTareas extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_id',
        'personas_nuevo',
        'personas_anterior',
        'horas_nueva',
        'horas_anterior',
        'tarifa_nueva',
        'tarifa_anterior',
        'presupuesto_nuevo',
        'presupuesto_anterior',
        'descripcion_nuevo',
        'descripcion_anterior',
        'titulo_nuevo',
        'titulo_anterior',
        'tarea_id',
        'semana'

    ];

    public function tarea()
    {
        return $this->hasOne(Tarea::class,'id','tarea_id');
    }
}

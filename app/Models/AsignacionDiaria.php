<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionDiaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_lote_id'
    ];

    public function rendimiento()
    {
        return $this->hasMany(RendimientoDiario::class, 'asignacion_diaria_id','id')->where('terminado',1);
    }

    
}

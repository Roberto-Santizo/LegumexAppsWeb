<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareasLote extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_semanal_finca_id',
        'lote_id',
        'tarea_id',
        'personas',
        'presupuesto',
        'horas',
        'tarifa',
        'estado',
        'fecha_ejecucion'
    ];

    public function lote()
    {
        return $this->hasOne(Lote::class, 'id','lote_id');
    }

    public function tarea()
    {
        return $this->hasOne(Tarea::class, 'id','tarea_id');
    }
}

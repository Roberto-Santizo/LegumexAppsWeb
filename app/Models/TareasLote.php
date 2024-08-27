<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'fecha_ejecucion',
        'cupos',
        'horas_persona'
    ];

    public function lote()
    {
        return $this->hasOne(Lote::class, 'id','lote_id');
    }

    public function tarea()
    {
        return $this->hasOne(Tarea::class, 'id','tarea_id');
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionDiaria::class, 'tarea_lote_id', 'id');
    }

    public function usuarios()
    {
        return $this->hasMany(UsuarioTareaLote::class, 'tarealote_id','id')->whereDate('created_at',Carbon::today());
    }
}

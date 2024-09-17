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
        'estado',
        'fecha_ejecucion',
        'cupos',
        'horas_persona',
        'extraordinaria'
    ];

    public function plansemanal()
    {
        return $this->belongsTo(PlanSemanalFinca::class, 'plan_semanal_finca_id','id');
    }

    public function lote()
    {
        return $this->hasOne(Lote::class, 'id','lote_id');
    }

    public function tarea()
    {
        return $this->hasOne(Tarea::class, 'id','tarea_id');
    }

    public function asignacion()
    {
        return $this->hasOne(AsignacionDiaria::class, 'tarea_lote_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(UsuarioTareaLote::class, 'tarealote_id','id');
    }

    public function cierre()
    {
        return $this->hasOne(RendimientoDiario::class, 'tarea_lote_id','id');
    }
}

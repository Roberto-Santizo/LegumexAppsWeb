<?php

namespace App\Models;

use App\Models\Lote;
use Illuminate\Support\Carbon;
use App\Models\UsuarioTareaCosecha;
use App\Models\AsignacionDiariaCosecha;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TareaLoteCosecha extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_cosecha_id',
        'lote_id',
        'plan_semanal_finca_id'
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
        return $this->belongsTo(TareaCosecha::class, 'tarea_cosecha_id','id');
    }

    public function users()
    {
        return $this->hasMany(UsuarioTareaCosecha::class, 'tarealotecosecha_id','id');
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionDiariaCosecha::class, 'tarea_lote_cosecha_id', 'id');
    }

    public function asignacionDiaria($fecha = null)
    {
        if($fecha == null){
            $fecha = Carbon::today();
        }
        return $this->hasOne(AsignacionDiariaCosecha::class, 'tarea_lote_cosecha_id', 'id')->whereDate('created_at',$fecha);
    }

    public function cierres()
    {
        return $this->hasMany(CierreTareaLoteCosecha::class, 'tarea_lote_cosecha_id','id');
    }

    public function cierreSemanal()
    {
        return $this->hasOne(CierreTareaLoteCosechaSemanal::class, 'tarea_lote_cosecha_id','id');
    }

    public function cierreDiario($fecha = null)
    {
        if($fecha == null){
            $fecha = Carbon::today();
        }
        return $this->hasOne(CierreTareaLoteCosecha::class, 'tarea_lote_cosecha_id','id')->where('tipo_cierre',0)->whereDate('created_at',$fecha);
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSemanalFinca extends Model
{
    use HasFactory;

    protected $fillable = [
        'finca_id',
        'semana',
        'code',
    ];

    public function finca()
    {
        return $this->hasOne(Finca::class, 'id','finca_id');
    }

    public function tareasPorLote($lote_id)
    {
        return $this->hasMany(TareasLote::class, 'plan_semanal_finca_id','id')->where('lote_id',$lote_id);
    }

    public function tareasTotales()
    {
        return $this->hasMany(TareasLote::class, 'plan_semanal_finca_id','id');
    }

    public function tareasCosechaTotales()
    {
        return $this->hasMany(TareaLoteCosecha::class, 'plan_semanal_finca_id','id');
    }


}

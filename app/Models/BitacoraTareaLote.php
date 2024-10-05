<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraTareaLote extends Model
{
    use HasFactory;
    protected $table = 'bitacora_tarea_lote';

    protected $fillable = [
        'plan_semanal_id_dest',
        'plan_semanal_id_org',
        'tarea_lote_id',
    ];

    public function plan_origen()
    {
        return $this->hasOne(PlanSemanalFinca::class, 'id','plan_semanal_id_org');
    }
}

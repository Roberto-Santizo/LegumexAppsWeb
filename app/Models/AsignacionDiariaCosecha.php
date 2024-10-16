<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionDiariaCosecha extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'tarea_lote_cosecha_id'
    ];

    public function cierre()
    {
        return $this->hasOne(CierreTareaLoteCosecha::class, 'asignacion_diaria_cosechas_id','id');
    }
}

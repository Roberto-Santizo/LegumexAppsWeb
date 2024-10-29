<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreTareaLoteCosecha extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_lote_cosecha_id',
        'terminado',
        'tipo_cierre',
        'plantas_cosechadas',
        'libras_total_finca',
        'libras_total_planta',
        'asignacion_diaria_cosechas_id'
    ];
}

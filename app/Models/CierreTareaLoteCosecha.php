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
        'plantas_cosechadas'
    ];
}

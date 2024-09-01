<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendimientoDiario extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_lote_id',
        'terminado',
    ];
}

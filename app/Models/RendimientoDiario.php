<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendimientoDiario extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacion_diaria_id',
        'usuario_asignacion_id',
        'terminado',
    ];
}

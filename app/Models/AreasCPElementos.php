<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasCPElementos extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentocp_area',
        'elemento_id',
        'ok',
        'problema',
        'accion',
        'orden_trabajos_id'
    ];
}

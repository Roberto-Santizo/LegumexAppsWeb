<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsumoTarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'insumo_id',
        'tarea_lote_id',
        'cantidad_asignada',
        'cantidad_usada'
    ];

    public function insumo() 
    {
        return $this->belongsTo(Insumo::class);
    }
}

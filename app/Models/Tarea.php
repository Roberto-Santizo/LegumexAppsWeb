<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea',
        'descripcion',
        'code',
    ];

    public function asignacionesHistorico()
    {
        return $this->hasMany(TareasLote::class, 'tarea_id','id');
    }
}

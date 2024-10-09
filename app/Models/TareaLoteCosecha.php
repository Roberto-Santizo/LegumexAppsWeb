<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaLoteCosecha extends Model
{
    use HasFactory;

    protected $fillable = [
        'tarea_id',
        'lote_id',
        'plan_semanal_finca_id'
    ];

    public function lote()
    {
        return $this->hasOne(Lote::class, 'id','lote_id');
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class, 'tarea_id','id');
    }

    public function users()
    {
        return $this->hasMany(UsuarioTareaCosecha::class, 'tarealotecosecha_id','id');
    }
}

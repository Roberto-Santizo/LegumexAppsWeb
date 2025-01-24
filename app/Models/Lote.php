<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cdp_id',
        'finca_id',
        'estado',
    ];

    public function cdp()
    {
        return $this->hasOne(ControlPlantacion::class,'id','cdp_id');
    }

    public function finca()
    {
        return $this->belongsTo(Finca::class,'finca_id','id');
    }

    public function tareas()
    {
        return $this->hasMany(TareasLote::class,'lote_id','id');
    }

    public function tareasCosecha()
    {
        return $this->hasMany(TareaLoteCosecha::class,'lote_id','id');
    }
}

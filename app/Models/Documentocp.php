<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentocp extends Model
{
    use HasFactory;

    protected $fillable = [
        'planta_id',
        'fecha',
        'observaciones',
        'verificado_firma',
        'jefemanto_firma',
        'supervisor_firma',
        'weburl',
        'estado'
    ];

    
    public function planta()
    {
        return $this->hasOne(Planta::class,'id','planta_id');
    }

    public function ordenes(){
        return $this->hasMany(OrdenChecklist::class, 'documentocps_id', 'id');
    }

    public function areas()
    {
        return $this->hasMany(AreasChecklistP::class,'documentocps_id','id');
    }

    
}

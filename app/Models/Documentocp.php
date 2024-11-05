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
        'estado',
        'correlativo',
        'user_id'
    ];

    
    public function planta()
    {
        return $this->belongsTo(Planta::class);
    }

    public function ordenes(){
        return $this->hasMany(OrdenChecklist::class, 'documentocps_id', 'id');
    }

    public function areas()
    {
        return $this->hasMany(AreasChecklistP::class,'documentocps_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}

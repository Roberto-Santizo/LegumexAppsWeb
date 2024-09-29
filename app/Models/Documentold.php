<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentold extends Model
{
    use HasFactory;

    protected $fillable = [
        'tecnico_mantenimiento',
        'planta_id',
        'area_id',
        'fecha',
        'observaciones',
        'entrada',
        'observaciones_entrada',
        'firma_entrada',
        'salida',
        'observaciones_salida',
        'firma_salida',
        'tecnico_firma',
        'inspector_firma',
        'asistente_firma',
        'estado',
        'weburl',
        'correlativo'
    ];

    public function herramientas()
    {
        return $this->hasMany(Herramientas_documentold::class, 'documentold_id');
    }

    public function planta()
    {
        return $this->belongsTo(Planta::class);
    }

    public function area()
    {
        return $this->hasOne(Area::class,'id','area_id');
    }
}

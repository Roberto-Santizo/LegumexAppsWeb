<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenTrabajo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'planta_id',
        'area_id',
        'elemento_id',
        'nombre_solicitante',
        'firma_solicitante',
        'equipo_problema',
        'retiro_equipo',
        'fecha_propuesta',
        'problema_detectado',
        'estado_id',
        'nombre_jefearea',
        'firma_jefearea',
        'fecha_entrega',
        'fecha_inspeccion',
        'hora_inicio',
        'hora_final',
        'urgencia',
        'trabajo_realizado',
        'repuestos_utilizados',
        'firma_mecanico',
        'jefemanto_nombre',
        'jefemanto_firma',
        'limpieza_equipo',
        'orden_area',
        'liberacion_trabajo',
        'nombre_calidad',
        'fecha_inspeccion_calidad',
        'firma_calidad',
        'especifique',
        'weburl',
        'devolucion_equipo',
        'observaciones_eliminacion'
        
    ];

    public function estado()
    {
        return $this->hasOne(Estado::class,'id','estado_id');
    }

    public function planta()
    {
        return $this->hasOne(Planta::class,'id','planta_id');
    }

    public function area()
    {
        return $this->hasOne(Area::class,'id','area_id');
    }

    public function elemento()
    {
        return $this->hasOne(Elemento::class,'id','elemento_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class,'mecanico_id','id');
    }
}

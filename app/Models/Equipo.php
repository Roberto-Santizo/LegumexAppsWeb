<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{

    protected $casts = [
        'acquisition_date' => 'datetime',
        'installation_date' => 'datetime',
    ];
    protected $fillable = [
        'name',
        'code',
        'serie',
        'modelo',
        'acquisition_date',
        'installation_date',
        'area_id',
        'folder_url'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function accesorios()
    {
        return $this->hasMany(EquipoAccesorios::class);
    }

    public function trabajosPreventivos()
    {
        return $this->hasMany(TrabajoEquipo::class)->where('status',1);
    }

    public function trabajosRealizados()
    {
        return $this->hasMany(TrabajoEquipo::class)->where('status',0);
    }
}

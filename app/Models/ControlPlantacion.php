<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlPlantacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'semana',
        'cultivo_id',
    ];

    public function cultivo()
    {
        return $this->hasOne(Cultivo::class,'id','cultivo_id');
    }
}

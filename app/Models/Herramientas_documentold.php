<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramientas_documentold extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentold_id',
        'herramienta_id',
        'desinfectada_entrada',
        'lavada_entrada',
        'desinfectada_salida',
        'lavada_salida',

    ];


    public function documentold()
    {
        return $this->belongsTo(Documentold::class, 'documentold_id');
    }

    public function herramienta()
    {
        return $this->hasOne(Herramienta::class,'id','herramienta_id');
    }
}

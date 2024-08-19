<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BitacoraLotes extends Model
{
    use HasFactory;

    protected $fillable = [
        'lote_id',
        'cdp_anterior',
        'cdp_nuevo',
        'estado_anterior',
        'estado_nuevo',
        'semana_cambio',
    ];

    public function lote()
    {
        return $this->hasOne(Lote::class,'id','lote_id');
    }

    
}

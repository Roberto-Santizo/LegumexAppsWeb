<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTareaCosecha extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'tarealotecosecha_id',
        'nombre',
        'codigo'
    ];

    public function tarealote()
    {
        return $this->belongsTo(TareaLoteCosecha::class, 'tarealotecosecha_id','id');
    }
}

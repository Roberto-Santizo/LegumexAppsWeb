<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTareaLote extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'tarealote_id',
    ];
}

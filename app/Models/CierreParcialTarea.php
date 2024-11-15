<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CierreParcialTarea extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_final' => 'datetime'
    ];

    protected $fillable = [
        'tarealote_id',
        'fecha_inicio',
        'fecha_final'
    ];
}

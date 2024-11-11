<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'area',
        'planta_id',
        'created_at',
        'updated_at'
    ];

    public function elementos()
    {
        return $this->hasMany(Elemento::class, 'area_id');
    }

    public function planta()
    {
        return $this->belongsTo(Planta::class);
    }
}

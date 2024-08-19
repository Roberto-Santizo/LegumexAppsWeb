<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSemanalFinca extends Model
{
    use HasFactory;

    protected $fillable = [
        'finca_id',
        'semana'
    ];

    public function finca()
    {
        return $this->hasOne(Finca::class, 'id','finca_id');
    }

}

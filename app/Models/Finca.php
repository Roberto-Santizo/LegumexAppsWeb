<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Finca extends Model
{
    use HasFactory;

    protected $fillable = [
        'finca',
    ];

   
    public function lotes()
    {
        return $this->hasMany(Lote::class, 'finca_id','id')->where('estado',1);
    }
}

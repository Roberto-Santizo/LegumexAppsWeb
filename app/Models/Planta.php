<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    use HasFactory;

    public function areas()
    {
        return $this->hasMany(Area::class, 'planta_id');
    }
}

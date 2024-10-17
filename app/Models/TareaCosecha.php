<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaCosecha extends Model
{
    use HasFactory;

    public function cultivo()
    {
        return $this->hasOne(Cultivo::class, 'id','cultivo_id');
    }

}

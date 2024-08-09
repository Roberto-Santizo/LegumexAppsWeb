<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role_id',
        'status',
    ];

    public function role()
    {
        return $this->hasOne(Role::class,'id','role_id');
    }
}

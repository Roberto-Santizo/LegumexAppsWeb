<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
    use HasFactory;

    protected $fillable = [
      'elemento',
      'area_id'  ,
      'created_at',
      'updated_at'
    ];
    
}

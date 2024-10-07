<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoFinca extends Model
{
    use HasFactory;

    // protected $connection = 'sqlsrv_public';
    protected $table = 'personnel_employee';

    public $timestamps  = false;


}

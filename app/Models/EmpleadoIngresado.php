<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoIngresado extends Model
{
    use HasFactory;
    
    // protected $connection = 'sqlsrv_public';
    protected $table = 'iclock_transaction';

    public $timestamps  = false;

    protected $casts = [
        'punch_time' => 'datetime',
    ];

    public function empleado()
    {
        return $this->hasOne(EmpleadoFinca::class,'id','emp_id');
    }

    public function lugar()
    {
        return $this->hasOne(Terminal::class,'id','terminal_id');
    }

}

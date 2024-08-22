<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;
      
    protected $connection = 'sqlsrv_public';
    protected $table = 'iclock_terminal';

    public $timestamps  = false;

}

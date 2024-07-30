<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentocps_id',
        'orden_trabajos_id'
    ];



    public function documentocp()
    {
        return $this->belongsTo(Documentocp::class, 'documentocps_id', 'id');
    }

    public function orden()
    {
        return $this->belongsTo(OrdenTrabajo::class, 'orden_trabajos_id', 'id');
    }
}

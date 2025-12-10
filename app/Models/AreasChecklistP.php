<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasChecklistP extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'documentocps_id',
        'firma'    
    ];


    public function area()
    {
        return $this->hasOne(Area::class,'id','area_id');
    }

    public function documentocp()
    {
        return $this->belongsTo(Documentocp::class,'documentocps_id','id');
    }

    public function elementos()
    {
        return $this->hasMany(AreasCPElementos::class,'documentocp_area','id');
    }
}

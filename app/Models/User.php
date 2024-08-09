<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\View\Components\OrdenesdeTrabajo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function is_admin(){
        return $this->getRoleNames()->contains('admin');
    }

    public function is_adminmanto(){
        return $this->getRoleNames()->contains('adminmanto');
    }

    public function ordenes(){
        $numero_ordenes_pendientes = OrdenTrabajo::all()
                            ->where('mecanico_id',$this->id)
                            ->where('estado_id',1)
                            ->count();
        return $numero_ordenes_pendientes;
    }
}

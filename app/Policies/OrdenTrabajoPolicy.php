<?php

namespace App\Policies;

use App\Models\OrdenTrabajo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrdenTrabajoPolicy
{
   
    public function delete(User $user, OrdenTrabajo $ordenTrabajo) : Response
    {
        return $user->getRoleNames()->contains('admin') ? Response::allow() : Response::deny();
    }
}

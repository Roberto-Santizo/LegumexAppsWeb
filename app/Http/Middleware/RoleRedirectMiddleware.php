<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $userRole = $user->getRoleNames()->first();

        $roleRedirects = [
            'admin' => '/dashboard/administracion',
            'adminmanto' => '/dashboard/mantenimiento',
            'adminagricola' => '/dashboard/agricola',
            'auxmanto' => '/dashboard/mantenimiento',
            'auxalameda' => '/dashboard/agricola',
        ];

        if($user && array_key_exists($userRole,$roleRedirects)){
            return redirect($roleRedirects[$userRole]);
        }

        return $next($request);
    }
}

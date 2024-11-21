<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAppUpdate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $currentVersion = config('app.current_version');
        if($user && $user->getRoleNames()->first() === 'admin')
        {
            if ($user && $user->last_seen_version !== $currentVersion) {
                session()->flash('update', "¡Nueva actualización disponible! Agrega el cálculo de la distribución del presupuesto y horas por usuario");
                $user->last_seen_version = $currentVersion;
                $user->save();
            }
        }

        return $next($request);
    }
}

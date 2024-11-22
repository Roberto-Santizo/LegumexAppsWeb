<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
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
        if($user && ($user->getRoleNames()->first() === 'admin' || $user->getRoleNames()->first() === 'adminagricola'))
        {
            if ($user && $user->last_seen_version !== $currentVersion) {
                $token = Str::random(40);
                $user->last_seen_version = $currentVersion;
                $user->save();
                return redirect()->route('novedades')->with('token',$token);
            }
        }

        return $next($request);
    }
}

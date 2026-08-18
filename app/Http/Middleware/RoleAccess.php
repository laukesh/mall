<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int|string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $currentRoleId = (int) role_id();

        if (in_array($currentRoleId, [1, 2], true)) {
            return $next($request);
        }

        $allowedRoles = array_map(function ($role) {
            return (int) $role;
        }, $roles);

        if (empty($allowedRoles) || !in_array($currentRoleId, $allowedRoles, true)) {
            return redirect('/home')->with('error', 'Access denied.');
        }

        return $next($request);
    }
}

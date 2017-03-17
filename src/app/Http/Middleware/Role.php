<?php

namespace Afrittella\BackProject\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $role
     * @param $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = "")
    {
        if (Auth::guest()) {
            return redirect()->guest('login');
        }

        if (! $request->user()->hasRole($role)) {
            abort(403);
        }

        if (!empty($permission) and ! $request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);
    }
}

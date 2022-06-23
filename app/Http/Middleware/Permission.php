<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $permission
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route(RouteServiceProvider::LOGIN);
        }

        $arrPermissions = $user->roles()->first()->permissions()->get()->map(function ($item) {
            return $item->name;
        })->toArray();

        $specificPermission = $user->permissions()->get()->map(function ($item) {
            return $item->name;
        })->toArray();

        if (in_array($permission, $arrPermissions) || in_array($permission, $specificPermission)) {
            return $next($request);
        }

        return abort(404);
    }
}

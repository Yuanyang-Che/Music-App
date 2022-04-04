<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventBlockedUsers
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $requestedRouteName = $request->route()->getName();

        $isBlocked = Auth::user()->is_blocked;

        if ($isBlocked && $requestedRouteName !== ('blocked')) {
            return redirect()->route('blocked');
        }

        //Non-blocked user try to access blocked page
        if (!$isBlocked && $requestedRouteName == ('blocked')) {
            return redirect()->route('profile.index');
        }

        return $next($request);
    }
}

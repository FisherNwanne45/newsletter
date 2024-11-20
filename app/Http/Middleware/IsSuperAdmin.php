<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Ensure the User model is imported

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // Explicitly cast Auth::user() to the User model
        /** @var User $user */
        $user = Auth::user();

        // Check if the user has the "super_admin" role
        if (!$user->isSuperAdmin()) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        // Allow the request to proceed
        return $next($request);
    }
}
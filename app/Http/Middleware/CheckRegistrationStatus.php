<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class CheckRegistrationStatus
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
    $registrationSetting = Setting::where('name', 'registration_enabled')->first();

    // If registration is disabled and the user is accessing the register route
    if (!$registrationSetting || !$registrationSetting->value) {
        if ($request->route()->named('register')) {
            return redirect()->route('login')->with('error', 'Registration is currently disabled.');
        }
    }

    return $next($request);
}

}
<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        // Only allow Super Admins to access this page
        $this->middleware('superadmin');
    }

    public function index()
    {
        // Get the current registration status from the settings table
        $registrationEnabled = Setting::where('name', 'registration_enabled')->first();

        return view('settings.index', compact('registrationEnabled'));
    }

    public function toggleRegistration(Request $request)
    {
        // Update the registration status in the settings table
        $setting = Setting::where('name', 'registration_enabled')->first();
        $setting->value = $request->has('registration_enabled');
        $setting->save();

        return redirect()->route('settings.index')->with('success', 'Registration status updated.');
    }
}
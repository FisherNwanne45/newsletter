<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;  // Make sure to import the User model

class ProfileController extends Controller
{
    /**
     * Show the form to change the password.
     */
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }

    /**
     * Handle the password change request.
     */
    public function changePassword(Request $request)
    {
        // Validate the form input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed', // Ensure password is confirmed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->route('profile.change-password')
                ->withErrors($validator)
                ->withInput();
        }

        // Get the currently authenticated user
        /** @var User $user */
        $user = Auth::user();  // Type-hinting user as an instance of User model

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.change-password')
                ->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        
        // Save the updated user model
        if ($user->save()) {
            // Redirect to the profile page with a success message
            return redirect()->route('profile.change-password')->with('success', 'Password changed successfully.');
        }

        // If for some reason the save fails, redirect with an error
        return redirect()->route('profile.change-password')
            ->withErrors(['error' => 'There was an issue changing your password. Please try again.']);
    }
}
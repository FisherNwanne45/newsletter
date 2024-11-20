<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Retrieve all users except the super admin
        $users = User::where('role', '!=', 'super_admin')->get();
        return view('admin.dashboard', compact('users'));
    }

    public function editPassword($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Password updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Ensure you don't delete the admin
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Cannot delete the super admin');
        }

        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully');
    }

    public function loginAsUser($id)
    {
        $user = User::findOrFail($id);

        // Log in as the selected user
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
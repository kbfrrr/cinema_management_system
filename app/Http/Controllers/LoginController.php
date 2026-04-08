<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::with('role')->where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withInput()->with('error', 'Invalid email or password.');
        }

        session([
            'user_id'   => $user->user_id,
            'user_name' => $user->name,
            'user_role' => $user->role->role_name,
        ]);

        // Redirect based on role
        return match($user->role->role_name) {
            'admin'  => redirect()->route('admin.dashboard'),
            'staff'  => redirect()->route('admin.dashboard'),
            default => redirect()->route('customer.home'),
        };
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role_id'  => 3, // customer
        ]);

        session([
            'user_id'   => $user->user_id,
            'user_name' => $user->name,
            'user_role' => 'customer',
        ]);

        return redirect()->route('customer.home');
    }
    
}
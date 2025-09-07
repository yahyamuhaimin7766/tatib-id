<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        // Password default: "admin123" (bisa diubah sesuai kebutuhan)
        if (Hash::check($request->password, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')) {
            session(['authenticated' => true]);
            return redirect()->route('home');
        }

        return back()->withErrors(['password' => 'Password salah']);
    }

    public function logout()
    {
        session()->forget('authenticated');
        return redirect()->route('login');
    }
}
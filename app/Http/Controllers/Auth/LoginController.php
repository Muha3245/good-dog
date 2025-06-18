<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
{
    $user = auth()->user();

    // if ($user) {
    //     if ($user->role === 'breeder') {
    //         return redirect()->route('dashboard');
    //     }

    //     return view('welcome'); // non-breeder users still see welcome
    // }

    return view('login'); // not logged in → show login
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        // $request->session()->regenerate();
        
        // Use the isBreeder() method from your User model
        if (Auth::user()->isBreeder()) {
            return redirect()->route('dashboard');
        }
        
        return redirect('/'); // or wherever non-breeders should go
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

    public function logout(Request $request)
    {
        Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
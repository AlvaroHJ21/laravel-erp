<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function index()
    {
        // valid if user is already logged in
        if (Auth::check()) {
            return redirect()->route("dashboard");
        }

        return view("auth.login");
    }

    public function login(Request $request)
    {
        //with email
        if (Auth::attempt($request->only("email", "password"))) {
            $request->session()->regenerate();
            return redirect()->route("dashboard");
        }
        return back()->withErrors([
            "email" => "The provided credentials do not match our records.",
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route("login");
    }
}

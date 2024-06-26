<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view("index");
    }

    public function login(Request $request)
    {
        $credentals = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        if (Auth::attempt($credentals)) {
            $request->session()->regenerate();
            return redirect(route("home"));
        }
        return back()->with(["message" => "Email or password not correct"]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        $request->session()->invalidate();

        return redirect(route("home"));
    }
}

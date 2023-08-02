<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view("Admin.pages.auth.adminLogin");
    }

    public function login(Request $request)
    {
        $credentials = $request->only(["email", "password"]);
        if (auth()->attempt($credentials) && auth()->user()->status == "active") {
            return redirect()->route("admin.index");
        }
        $this->handelLogout();
        return redirect()->back()->with(["error" => "Invalid Credentials"]);
    }

    public function logout()
    {
        $this->handelLogout();
        return redirect()->route("admin.loginPage");
    }

    private function handelLogout()
    {
        Auth::logout();
        session()->flush();
        session()->regenerate();
    }
}

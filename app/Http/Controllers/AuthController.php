<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view("login.index");
    }

    public function login(LoginRequest $request) {
        if(Auth::guard("web")->attempt([
            "username" => $request["username"],
            "password" => $request["password"]
        ])) {
            return redirect()->route("dashboard.index");
        }

        return back()->withErrors(["msg" => 'Username / Password Salah!!!']);
    }

    public function logout() {
        return view("login.index");
    }
}

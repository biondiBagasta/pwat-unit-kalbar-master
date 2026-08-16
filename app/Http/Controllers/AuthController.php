<?php

namespace App\Http\Controllers;


class AuthController extends Controller
{
    public function index() {
        return view("login.index");
    }

    public function logout() {
        return view("login.index");
    }
}

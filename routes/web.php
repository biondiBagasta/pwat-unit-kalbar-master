<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\backoffice\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(["prefix" => "auth"], function() {
    Route::get("login", [AuthController::class, "index"])->name("login.index");
    Route::post("logout", [AuthController::class, "logout"])->name("auth.logout");
});

Route::group(["prefix" => "backoffice"], function() {
    Route::get("dashboard", [DashboardController::class, "index"])->name("dashboard.index");
});

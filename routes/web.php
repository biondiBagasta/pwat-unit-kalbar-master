<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\backoffice\DashboardController;
use App\Http\Controllers\backoffice\MemberController;
use App\Http\Controllers\backoffice\MemberRoleController;
use App\Http\Controllers\backoffice\MemberTypeController;
use App\Http\Controllers\backoffice\UserController;
use App\Http\Controllers\backoffice\UserRoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('welcome');
});

Route::group(["prefix" => "auth"], function() {
    Route::get("login", [AuthController::class, "index"])->name("login.index");
    Route::post("logout", [AuthController::class, "logout"])->name("auth.logout");
});

// Storage Route
Route::get("storage/{folder}/{filename}", function($folder, $filename) {
    $path = storage_path('app/public/' . $folder . "/" . $filename);

    if(!file_exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});

Route::group(["prefix" => "backoffice"], function() {
    Route::get("dashboard", [DashboardController::class, "index"])->name("dashboard.index");

    // Member Roles Route
    Route::post("member-role/create", [MemberRoleController::class, "create"])->name("member-role.create");
    Route::get("member-role/edit/{id}", [MemberRoleController::class, "edit"])->name("member-role.edit");
    Route::put("member-role/update/{id}", [MemberRoleController::class, "update"])->name("member-role.update");
    Route::delete("member-role/delete/{id}", [MemberRoleController::class, "delete"])->name("member-role.delete");

    // User Roles Route
    Route::post("user-role/create", [UserRoleController::class, "create"])->name("user-role.create");
    Route::get("user-role/edit/{id}", [UserRoleController::class, "edit"])->name("user-role.edit");
    Route::put("user-role/update/{id}", [UserRoleController::class, "update"])->name("user-role.update");
    Route::delete("user-role/delete/{id}", [UserRoleController::class, "delete"])->name("user-role.delete");

    // User Route
    Route::get("user", [UserController::class, "index"])->name("user.index");
    Route::post("user/create", [UserController::class, "create"])->name("user.create");
    Route::put("user/update/{id}", [UserController::class, "update"])->name("user.update");
    Route::get("user/edit/{id}", [UserController::class, "edit"])->name("user.edit");
    Route::delete("user/delete/{id}", [UserController::class, "delete"])->name("user.delete");

    // Member Route
    Route::get("member", [MemberController::class, "index"])->name("member.index");

    // Member Role Route
    Route::post("member-role/create", [MemberRoleController::class, "create"])->name("member-role.create");
    Route::get("member-role/edit/{id}", [MemberRoleController::class, "edit"])->name("member-role.edit");
    Route::put("member-role/update/{id}", [MemberRoleController::class, "update"])->name("member-role.update");
    Route::delete("member-role/delete/{id}", [MemberRoleController::class, "delete"])->name("member-role.delete");

    // Member Type Route
    Route::post("member-type/create", [MemberTypeController::class, "create"])->name("member-type.create");
    Route::get("member-type/edit/{id}", [MemberTypeController::class, "edit"])->name("member-type.edit");
    Route::put("member-type/update/{id}", [MemberTypeController::class, "update"])->name("member-type.update");
    Route::delete("member-type/delete/{id}", [MemberTypeController::class, "delete"])->name("member-type.delete");
});

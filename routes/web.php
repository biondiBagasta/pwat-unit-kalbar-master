<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\backoffice\CarouselController;
use App\Http\Controllers\backoffice\DashboardController;
use App\Http\Controllers\backoffice\EventCategoryController;
use App\Http\Controllers\backoffice\EventController;
use App\Http\Controllers\backoffice\FinanceCategoryController;
use App\Http\Controllers\backoffice\FinanceController;
use App\Http\Controllers\backoffice\MemberController;
use App\Http\Controllers\backoffice\MemberProfileController;
use App\Http\Controllers\backoffice\MemberRoleController;
use App\Http\Controllers\backoffice\MemberTypeController;
use App\Http\Controllers\backoffice\PostCategoryController;
use App\Http\Controllers\backoffice\PostController;
use App\Http\Controllers\backoffice\SuggestionCategoryController;
use App\Http\Controllers\backoffice\SuggestionController;
use App\Http\Controllers\backoffice\UserController;
use App\Http\Controllers\backoffice\UserRoleController;
use App\Http\Middleware\BackofficePageMiddleware;
use App\Http\Middleware\LoginPageMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', function () {
    return view('welcome');
});

Route::group(["prefix" => "auth"], function() {
    Route::get("login", [AuthController::class, "index"])->name("login.index")
    ->middleware(LoginPageMiddleware::class);

    Route::post("login", [AuthController::class, "login"])->name("auth.login");
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

Route::group(["prefix" => "backoffice", "middleware" => BackofficePageMiddleware::class], function() {
    Route::get("dashboard", [DashboardController::class, "index"])->name("dashboard.index");

    // Carousel Route
    Route::get("carousel", [CarouselController::class, "index"])->name("carousel.index");
    Route::post("carousel/create", [CarouselController::class, "create"])->name("carousel.create");
    Route::put("carousel/update/{id}", [CarouselController::class, "update"])->name("carousel.update");
    Route::get("carousel/edit/{id}", [CarouselController::class, "edit"])->name("carousel.edit");
    Route::delete("carousel/delete/{id}", [CarouselController::class, "delete"])->name("carousel.delete");


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
    Route::post("member/create", [MemberController::class, "create"])->name("member.create");
    Route::get("member/edit/{id}", [MemberController::class, "edit"])->name("member.edit");
    Route::put("member/update/{id}", [MemberController::class, "update"])->name("member.update");
    Route::put("member/update-profile/{id}", [MemberController::class, "updateProfile"])->name("member.update-profile");
    Route::delete("member/delete/{id}", [MemberController::class, "delete"])->name("member.delete");
    Route::post("member/check-username", [MemberController::class, "checkUsername"])->name("member.check-username");
    Route::post("member/check-username-update-profile", [MemberController::class, "checkUsernameUpdateProfile"])->name("member.check-username-update-profile");
    Route::post("member/find-many-regency", [MemberController::class, "findManyRegency"])->name("member.find-many-regency");

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

    // Suggestion Category Route
    Route::post("suggestion-category/create", [SuggestionCategoryController::class, "create"])->name("suggestion-category.create");
    Route::get("suggestion-category/edit/{id}", [SuggestionCategoryController::class, "edit"])->name("suggestion-category.edit");
    Route::put("suggestion-category/update/{id}", [SuggestionCategoryController::class, "update"])->name("suggestion-category.update");
    Route::delete("suggestion-category/delete/{id}", [SuggestionCategoryController::class, "delete"])->name("suggestion-category.delete");

    // Suggestion Route
    Route::get("suggestion", [SuggestionController::class, "index"])->name("suggestion.index");
    Route::post("suggestion/create", [SuggestionController::class, "create"])->name("suggestion.create");
    Route::put("suggestion/update/{id}", [SuggestionController::class, "update"])->name("suggestion.update");
    Route::get("suggestion/edit/{id}", [SuggestionController::class, "edit"])->name("suggestion.edit");
    Route::delete("suggestion/delete/{id}", [SuggestionController::class, "delete"])->name("suggestion.delete");

    // Post Category Route
    Route::post("post-category/create", [PostCategoryController::class, "create"])->name("post-category.create");
    Route::get("post-category/edit/{id}", [PostCategoryController::class, "edit"])->name("post-category.edit");
    Route::put("post-category/update/{id}", [PostCategoryController::class, "update"])->name("post-category.update");
    Route::delete("post-category/delete/{id}", [PostCategoryController::class, "delete"])->name("post-category.delete");

    // Post Route
    Route::get("post", [PostController::class, "index"])->name("post.index");
    Route::post("post/create", [PostController::class, "create"])->name("post.create");
    Route::put("post/update/{id}", [PostController::class, "update"])->name("post.update");
    Route::put("post/update-status/{id}", [PostController::class, "updateStatus"])->name("post.update-status");
    Route::get("post/edit/{id}", [PostController::class, "edit"])->name("post.edit");
    Route::delete("post/delete/{id}", [PostController::class, "delete"])->name("post.delete");

    // Event Category Route
    Route::post("event-category/create", [EventCategoryController::class, "create"])->name("event-category.create");
    Route::get("event-category/edit/{id}", [EventCategoryController::class, "edit"])->name("event-category.edit");
    Route::put("event-category/update/{id}", [EventCategoryController::class, "update"])->name("event-category.update");
    Route::delete("event-category/delete/{id}", [EventCategoryController::class, "delete"])->name("event-category.delete");

    // Event Route
    Route::get("event", [EventController::class, "index"])->name("event.index");
    Route::post("event/create", [EventController::class, "create"])->name("event.create");
    Route::put("event/update/{id}", [EventController::class, "update"])->name("event.update");
    Route::get("event/edit/{id}", [EventController::class, "edit"])->name("event.edit");
    Route::delete("event/delete/{id}", [EventController::class, "delete"])->name("event.delete");

    Route::post("event/upload-galleries", [EventController::class, "uploadGalleriesEventImage"])->name("event.upload-galleries");
    Route::delete("event/delete-gallery/{id}", [EventController::class, "deleteGallery"])->name("event.delete-gallery");

    // Finance Category Route
    Route::post("finance-category/create", [FinanceCategoryController::class, "create"])->name("finance-category.create");
    Route::get("finance-category/edit/{id}", [FinanceCategoryController::class, "edit"])->name("finance-category.edit");
    Route::put("finance-category/update/{id}", [FinanceCategoryController::class, "update"])->name("finance-category.update");
    Route::delete("finance-category/delete/{id}", [FinanceCategoryController::class, "delete"])->name("finance-category.delete");

    // Finance Route
    Route::get("finance", [FinanceController::class, "index"])->name("finance.index");
    Route::post("finance/create", [FinanceController::class, "create"])->name("finance.create");
    Route::put("finance/update/{id}", [FinanceController::class, "update"])->name("finance.update");
    Route::get("finance/edit/{id}", [FinanceController::class, "edit"])->name("finance.edit");
    Route::delete("finance/delete/{id}", [FinanceController::class, "delete"])->name("finance.delete");

    // Member Profile Route
    Route::get("member-profile/overview/{id}", [MemberProfileController::class, "overviewPage"])->name("member-profile.overview");
    Route::get("member-profile/post/{id}", [MemberProfileController::class, "postPage"])->name("member-profile.post");
    Route::get("member-profile/suggestion/{id}", [MemberProfileController::class, "suggestionPage"])->name("member-profile.suggestion");
});

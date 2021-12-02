<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return view("auth.login");
});

Route::group(["middleware" => ["auth:sanctum", "verified"]], function () {
    Route::get("/dashboard", \App\Http\Livewire\DocumentsLivewire::class)->name(
        "dashboard"
    );
    Route::get(
        "/dashboard?designation={designation}",
        \App\Http\Livewire\DocumentsLivewire::class
    )->name("designation");
    Route::get(
        "/dashboard/filerequests",
        \App\Http\Livewire\NotificationsLivewire::class
    )->name("notifications");
    Route::get(
        "/dashboard/users",
        \App\Http\Livewire\AdminUsersLivewire::class
    )->name("admin-users");
});

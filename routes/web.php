<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/login', [LoginController::class, "index"])->name("login");
Route::post('/login', [LoginController::class, "login"])->name("login");
Route::middleware("auth")->get('/logout', [LoginController::class, "logout"])->name("logout");

Route::middleware("auth")->get("/", function () {
    return redirect(route("admin.event.index"));
})->name("home");

Route::middleware("auth")->prefix("admin")->as("admin.")->group(function () {
    Route::prefix("event")->as("event.")->group(function () {
        Route::get("index", [EventController::class, "index"])->name("index");
    });
});

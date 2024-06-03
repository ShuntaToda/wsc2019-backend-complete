<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TicketController;
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
        Route::get("create", [EventController::class, "create"])->name("create");
        Route::post("create", [EventController::class, "store"])->name("create");
        Route::get("detail/{id}", [EventController::class, "show"])->name("detail");
        Route::get("edit/{id}", [EventController::class, "edit"])->name("edit");
        Route::post("edit/{id}", [EventController::class, "update"])->name("edit");
    });

    Route::prefix("report")->as("report.")->group(function () {
        Route::get("index", function () {
            return view("reports.index");
        })->name("index");
    });

    Route::prefix("ticket")->as("ticket.")->group(function () {
        Route::get("create", [TicketController::class, "create"])->name("create");
        Route::post("create", [TicketController::class, "store"])->name("create");
    });
});

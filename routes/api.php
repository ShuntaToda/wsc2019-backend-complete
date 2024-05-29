<?php

use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("v1")->group(function () {
    Route::post('login', [LoginController::class, "login"]);

    Route::middleware("auth:sanctum")->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('logout', [LoginController::class, "logout"]);
    });

    Route::get('events', [EventController::class, "index"]);

    Route::get("organizers/{organizer_slug}/events/{event_slug}", [EventController::class, "show"]);
    Route::post("organizers/{organizer_slug}/events/{event_slug}", [EventController::class, "store"]);
});

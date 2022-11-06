<?php

use App\Http\Controllers\WelcomeController;
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

Route::get("/", [ WelcomeController::class, "show" ])
    ->name("welcome");

Route::post("/", [ WelcomeController::class, "store" ])
    ->name("welcome.store");

Route::post("/settings", [ WelcomeController::class, "settings" ])
    ->name("settings");

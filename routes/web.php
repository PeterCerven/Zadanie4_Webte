<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

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

Route::get('/', [LocationController::class, 'index']);

Route::post("/locations",[LocationController::class, 'store']);

Route::post("/current",[LocationController::class, 'storeCurrent']);

Route::get("/locations/{location}",[LocationController::class, 'show']);


Route::get("/countries/{country}",[LocationController::class, 'countryTable']);

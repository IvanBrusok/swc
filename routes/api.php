<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('event/create', [EventController::class, 'create']);
    Route::get('event', [EventController::class, 'get']);
    Route::put('event/{id}/participate', [EventController::class, 'participate']);
    Route::delete('event/{id}/participate', [EventController::class, 'refuse']);
    Route::delete('event/{id}', [EventController::class, 'destroy']);
});

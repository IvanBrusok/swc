<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;

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

Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'authenticate']);
Route::get('registration', [UserController::class, 'registration'])->name('registration');
Route::post('registration', [UserController::class, 'register'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::post('event/get/{id}', [EventController::class, 'get']);
    Route::post('event/participate/{id}', [EventController::class, 'participate']);
    Route::post('event/refuse/{id}', [EventController::class, 'refuse']);
    Route::post('event/all', [EventController::class, 'getAll']);
    Route::post('event/member', [EventController::class, 'member']);
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebMovementController;
use App\Http\Controllers\WebAuthController;


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

Route::get('/login', function () {
    return view('login.login');
})->name('login');

Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');  
})->middleware('auth'); //
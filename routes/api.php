<?php

use App\Http\Controllers\Api\{
    AuthController,
    UserController,
};
use App\Http\Controllers\BreedController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register'])->name('user.register');
Route::post('login', [AuthController::class, 'login'])->name('user.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'me'])->name('user.me');
    Route::get('/breeds', [BreedController::class, 'index'])->name('getBreeds');
    Route::get('/breeds/{id}', [BreedController::class, 'show'])->name('getBreed');
});

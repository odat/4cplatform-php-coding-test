<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BreedController;

Route::get('/breeds', [BreedController::class, 'index']);

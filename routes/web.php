<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard-data', [DashboardController::class, 'data']);
Route::get('/data', [UserController::class, 'index']);
Route::post('/users/sync', [UserController::class, 'sync']);
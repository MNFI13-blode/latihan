<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/categories', [CategoryController::class, 'view']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::get('/coas', [CoaController::class, 'view']);
Route::post('/coas', [CoaController::class, 'store']);
Route::put('/coas/{id}', [CoaController::class, 'update']);
Route::delete('/coas/{id}', [CoaController::class, 'destroy']);

Route::get('/transactions', [TransactionController::class, 'view']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::put('/transactions/{id}', [TransactionController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

Route::get('/reports',[ReportController::class, 'profitLoss'])->name('reports');
Route::get('/profit-loss/export',[ReportController::class, 'exportExcel'])->name('profit-loss.export');
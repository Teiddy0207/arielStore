<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use  App\Http\Controllers\DashboardController;
use  App\Http\Controllers\UserPageController;



Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/api/get-orders', [OrderController::class, 'getOrder']);
Route::post('/api/update-status', [OrderController::class, 'updateStatus']);

Route::get('/api/order-detail/{id}', [OrderController::class, 'getOrderDetail']);


Route::get('/userpage', [UserPageController::class, 'index']);

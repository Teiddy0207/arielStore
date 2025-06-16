<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use  App\Http\Controllers\DashboardController;
use  App\Http\Controllers\UserPageController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;

// Auth routes (không cần middleware)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Protected routes (cần đăng nhập)
Route::middleware(['employee.auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/api/get-orders', [OrderController::class, 'getOrder']);
    Route::post('/api/update-status', [OrderController::class, 'updateStatus']);
    Route::get('/api/order-detail/{id}', [OrderController::class, 'getOrderDetail']);
    
    Route::get('/userpage', [UserPageController::class, 'index']);
    
    Route::resource('employee', EmployeeController::class);
    Route::patch('/employee/{employee}/toggle-active', [EmployeeController::class, 'toggleActive']);
});



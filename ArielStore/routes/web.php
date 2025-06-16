<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use  App\Http\Controllers\DashboardController;
use  App\Http\Controllers\UserPageController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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


    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/api/get-orders', [OrderController::class, 'getOrder']);
Route::post('/api/update-status', [OrderController::class, 'updateStatus']);

Route::get('/api/order-detail/{id}', [OrderController::class, 'getOrderDetail']);



use App\Http\Controllers\ProductController;
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::delete('/product-images/{productImage}', [ProductController::class, 'destroyImage'])->name('product-images.destroy');

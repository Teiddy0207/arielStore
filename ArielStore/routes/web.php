<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use  App\Http\Controllers\DashboardController;
use  App\Http\Controllers\UserPageController;
<<<<<<< HEAD
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

use App\Http\Controllers\ProductController;
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::delete('/product-images/{productImage}', [ProductController::class, 'destroyImage'])->name('product-images.destroy');

=======

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/api/get-orders', [OrderController::class, 'getOrder']);
Route::post('/api/update-status', [OrderController::class, 'updateStatus']);

Route::get('/api/order-detail/{id}', [OrderController::class, 'getOrderDetail']);

Route::get('/userpage', [UserPageController::class, 'index'])->name('userpage.index');
Route::get('/userpage/shirt', [UserPageController::class, 'showShirt'])->name('userpage.shirt');
Route::get('/userpage/pant', [UserPageController::class, 'showPant'])->name('userpage.pant');
Route::get('/userpage/skirt', [UserPageController::class, 'showSkirt'])->name('userpage.skirt');
Route::get('/userpage/accessories', [UserPageController::class, 'showAccessories'])->name('userpage.accessories');
Route::get('/userpage/all', [UserPageController::class, 'showAll'])->name('userpage.all');
Route::get('/userpage/sale', [UserPageController::class, 'showSale'])->name('userpage.sale');
Route::get('/userpage/new', [UserPageController::class, 'showNew'])->name('userpage.new');
>>>>>>> parent of 6a6f565 (Merge branch 'main' into userPage-new-)

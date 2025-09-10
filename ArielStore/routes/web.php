<?php

use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use  App\Http\Controllers\DashboardController;
use  App\Http\Controllers\UserPageController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/api/get-orders', [OrderController::class, 'getOrder']);
Route::post('/api/update-status', [OrderController::class, 'updateStatus']);

// Auth routes (không cần middleware)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['employee.auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/api/get-orders', [OrderController::class, 'getOrder']);
    Route::post('/api/update-status', [OrderController::class, 'updateStatus']);
    Route::get('/api/order-detail/{id}', [OrderController::class, 'getOrderDetail']);

    Route::get('/userpage', [UserPageController::class, 'index']);

    Route::resource('employee', EmployeeController::class);
    Route::patch('/employee/{employee}/toggle-active', [EmployeeController::class, 'toggleActive']);

    Route::prefix('statistic')->group(function () {
        Route::get('statistic/customer', [StatisticController::class, 'customer'])->name('statistic.customer');
        Route::get('statistic/inventory', [StatisticController::class, 'inventory'])->name('statistic.inventory');
        Route::get('/sales', [StatisticController::class, 'sales'])->name('statistic.sales');
        Route::get('/sales/days', [StatisticController::class, 'showDaySales'])->name('statistic.sales.days');
        Route::get('/sales/months', [StatisticController::class, 'showMonthSales'])->name('statistic.sales.months');
        Route::get('/sales/years', [StatisticController::class, 'showYearSales'])->name('statistic.sales.years');
        Route::get('/inventory/months', [StatisticController::class, 'showMonthInventory'])->name('statistic.inventory.months');
        Route::get('/inventory/years', [StatisticController::class, 'showYearInventory'])->name('statistic.inventory.years');
    });
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


Route::get('/userpage', [UserPageController::class, 'index'])->name('userpage.index');
Route::get('/userpage/shirt', [UserPageController::class, 'showShirt'])->name('userpage.shirt');
Route::get('/userpage/pant', [UserPageController::class, 'showPant'])->name('userpage.pant');
Route::get('/userpage/skirt', [UserPageController::class, 'showSkirt'])->name('userpage.skirt');
Route::get('/userpage/accessories', [UserPageController::class, 'showAccessories'])->name('userpage.accessories');
Route::get('/userpage/all', [UserPageController::class, 'showAll'])->name('userpage.all');
Route::get('/userpage/sale', [UserPageController::class, 'showSale'])->name('userpage.sale');
Route::get('/userpage/new', [UserPageController::class, 'showNew'])->name('userpage.new');
Route::get('/userpage/product/{id}', [UserPageController::class, 'showProduct'])->name('userpage.product');
Route::post('/userpage/product/{id}/add-to-cart', [UserPageController::class, 'addToCart'])->name('userpage.add-to-cart');
Route::get('/userpage/cart', [UserPageController::class, 'viewCart'])->name('userpage.cart');
Route::get('/userpage/checkout', [UserPageController::class, 'showcheckout'])->name('userpage.checkout');
Route::post('/userpage/checkout', [UserPageController::class, 'checkout'])->name('userpage.checkoutpost');
Route::get('/userpage/order-success/{orderId}', [UserPageController::class, 'orderSuccess'])->name('userpage.order-success');
Route::get('/userpage/search', [UserPageController::class, 'search'])->name('userpage.search');

// API thống kê (public or adjust middleware as needed)
Route::get('/api/statistic/sales/days', [StatisticController::class, 'statisticSaleDay']);
Route::get('/api/statistic/sales/days/chart', [StatisticController::class, 'statisticSaleDayChart']);
Route::get('/api/statistic/sales/months', [StatisticController::class, 'statisticSaleMonth']);

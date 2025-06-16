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

Route::get('/userpage', [UserPageController::class, 'index'])->name('userpage.index');
Route::get('/userpage/shirt', [UserPageController::class, 'showShirt'])->name('userpage.shirt');
Route::get('/userpage/pant', [UserPageController::class, 'showPant'])->name('userpage.pant');
Route::get('/userpage/skirt', [UserPageController::class, 'showSkirt'])->name('userpage.skirt');
Route::get('/userpage/accessories', [UserPageController::class, 'showAccessories'])->name('userpage.accessories');
Route::get('/userpage/all', [UserPageController::class, 'showAll'])->name('userpage.all');
Route::get('/userpage/sale', [UserPageController::class, 'showSale'])->name('userpage.sale');
Route::get('/userpage/new', [UserPageController::class, 'showNew'])->name('userpage.new');
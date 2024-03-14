<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController as FrontendProductController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CustomerController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/product', [FrontendProductController::class,'index'])->name('product.index');
Route::get('/category', [FrontendCategoryController::class,'index'])->name('category.index');
Route::get('/dashboard',[DashboardController::class,'index'])->name('user.dashboard');
Route::get('/customer',[CustomerController::class,'customer'])->name('admin.customer');
Route::post('/customer/table', [CustomerController::class, 'table'])->name('admin.customer.table');


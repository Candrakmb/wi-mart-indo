<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\master\categori\CategoriController;
use App\Http\Controllers\Backend\master\product\ProductController as BackendProductController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController as FrontendProductController;
use App\Http\Controllers\frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\order\OrderController;
use App\Http\Controllers\Backend\setting\AddBankController;

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


Route::prefix('categori')->name('categori.')->group(function(){
    Route::get('/',[CategoriController::class,'categori'])->name('categori');
    Route::post('/table', [CategoriController::class, 'table'])->name('table');
    Route::get('/create',[CategoriController::class,'create'])->name('create');
    Route::get('/update/{id}',[CategoriController::class,'update'])->name('update');
    Route::get('/lihat/{id}',[CategoriController::class,'lihat'])->name('lihat');
    Route::post('/updateform',[CategoriController::class,'updateform'])->name('updateform');
    Route::post('/createform',[CategoriController::class,'createform'])->name('createform');
    Route::post('/deleteform',[CategoriController::class,'deleteform'])->name('deleteform');
});

Route::prefix('add_bank')->name('add_bank.')->group(function(){
    Route::get('/',[AddBankController::class,'bank'])->name('bank');
    Route::post('/table', [AddBankController::class, 'table'])->name('table');
    Route::get('/create',[AddBankController::class,'create'])->name('create');
    Route::get('/update/{id}',[AddBankController::class,'update'])->name('update');
    Route::post('/updateform',[AddBankController::class,'updateform'])->name('updateform');
    Route::post('/createform',[AddBankController::class,'createform'])->name('createform');
    Route::post('/deleteform',[AddBankController::class,'deleteform'])->name('deleteform');
});

Route::prefix('product')->name('product.')->group(function(){
    Route::get('/',[BackendProductController::class,'product'])->name('product');
    Route::post('/table', [BackendProductController::class, 'table'])->name('table');
    Route::get('/create',[BackendProductController::class,'create'])->name('create');
    Route::get('/update/{id}',[BackendProductController::class,'update'])->name('update');
    Route::post('/updateform',[BackendProductController::class,'updateform'])->name('updateform');
    Route::post('/createform',[BackendProductController::class,'createform'])->name('createform');
    Route::post('/deleteform',[BackendProductController::class,'deleteform'])->name('deleteform');
});

Route::prefix('order')->name('order.')->group(function(){
    Route::get('/{status}',[OrderController::class,'order'])->name('order');
    Route::post('/table/{status}', [OrderController::class, 'table'])->name('table');
    Route::get('/update/{id}',[OrderController::class,'update'])->name('update');
    Route::post('/updateform',[OrderController::class,'updateform'])->name('updateform');
    Route::post('/createform',[OrderController::class,'createform'])->name('createform');
});

Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/',[CartController::class,'index'])->name('index');
    Route::post('/store',[CartController::class,'store'])->name('store');
    Route::post('/update',[CartController::class,'update'])->name('update');
    Route::get('/delete/{id}',[CartController::class,'delete'])->name('delete');
});

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/product', [FrontendProductController::class,'index'])->name('product.index');
Route::get('/category', [FrontendCategoryController::class,'index'])->name('category.index');
Route::get('/dashboard',[DashboardController::class,'index'])->name('user.dashboard');
Route::get('/customer',[CustomerController::class,'customer'])->name('admin.customer');
Route::post('/customer/table', [CustomerController::class, 'table'])->name('admin.customer.table');

// Route::get('/product/{categoriSlug}/{productSlug}',[FrontendProductController::class,'show'])->name('product.show');
Route::get('/product/baju/baju',[FrontendProductController::class,'show'])->name('product.show');

require __DIR__ . '/auth.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CustomerController;


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

Route::prefix('categori')->name('categori.')->group(function(){
    Route::get('/',[CategoriController::class,'categori'])->name('categori');
    Route::post('/table', [CategoriController::class, 'table'])->name('table');
    Route::get('/create',[CategoriController::class,'create'])->name('create');
    Route::get('/update/{id}',[CategoriController::class,'update'])->name('update');
    Route::post('/updateform',[CategoriController::class,'updateform'])->name('updateform');
    Route::post('/createform',[CategoriController::class,'createform'])->name('createform');
    Route::post('/deleteform',[CategoriController::class,'deleteform'])->name('deleteform');
});

Route::prefix('product')->name('product.')->group(function(){
    Route::get('/',[ProductController::class,'product'])->name('product');
    Route::post('/table', [ProductController::class, 'table'])->name('table');
    Route::get('/create',[ProductController::class,'create'])->name('create');
    Route::get('/update/{id}',[ProductController::class,'update'])->name('update');
    Route::post('/updateform',[ProductController::class,'updateform'])->name('updateform');
    Route::post('/createform',[ProductController::class,'createform'])->name('createform');
    Route::post('/deleteform',[ProductController::class,'deleteform'])->name('deleteform');
});
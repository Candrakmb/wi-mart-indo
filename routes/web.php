<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\master\categori\CategoriController;
use App\Notifications\Notificationtele;
use App\Http\Controllers\backend\master\product\ProductController as BackendProductController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProductController as FrontendProductController;
use App\Http\Controllers\frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\TransacationController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\CustomerController;
use App\Http\Controllers\backend\order\OrderController;
use App\Http\Controllers\backend\setting\AddBankController;
use App\Http\Controllers\Rajaongkir\RajaongkirController;
use App\Http\Controllers\Midtrans\MidtransController;
use App\Http\Controllers\backend\setting\AlamatPengirimController;
use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Notification;

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

Route::post('/payments/midtrans-success', [MidtransController::class, 'success']);



Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => ['can:manage admin portal']], function () { 
        Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
Route::get('/customer',[CustomerController::class,'customer'])->name('admin.customer');
Route::post('/customer/table', [CustomerController::class, 'table'])->name('admin.customer.table');
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
    
    Route::prefix('alamat_pengirim')->name('alamat_pengirim.')->group(function(){
        Route::get('/',[AlamatPengirimController::class,'alamat_pengirim'])->name('alamat_pengirim');
        Route::post('/updateform',[AlamatPengirimController::class,'updateform'])->name('updateform');
        Route::post('/createform',[AlamatPengirimController::class,'createform'])->name('createform');
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
        Route::get('/lihat/{id}',[OrderController::class,'lihat'])->name('lihat');
        Route::post('/konfirmasiform',[OrderController::class,'konfirmasiform'])->name('konfirmasiform');
        Route::post('/resiform',[OrderController::class,'resiform'])->name('resiform');
    });  
    });
   
});



Route::prefix('rajaongkir')->name('rajaongkir.')->group(function(){
    Route::post('/cost',[RajaongkirController::class,'cost'])->name('cost');
    Route::get('/province/{id}',[RajaongkirController::class,'getCity'])->name('city');
});




Route::middleware('auth','role:user', 'verified')->group(function(){

    Route::get('/home',[HomeController::class,'index'])->name('dashboard-user');

    Route::prefix('cart')->name('cart.')->group(function(){
        Route::get('/',[CartController::class,'index'])->name('index');
        Route::post('/store',[CartController::class,'store'])->name('store');
        Route::post('/update',[CartController::class,'update'])->name('update');
        Route::get('/delete/{id}',[CartController::class,'delete'])->name('delete');
    });
    
    Route::prefix('checkout')->name('checkout.')->group(function(){
        Route::get('/',[CheckoutController::class,'index'])->name('index');
        Route::post('/process',[CheckoutController::class,'process'])->name('process');
    });
    
    Route::prefix('transaction')->name('transaction.')->group(function(){
        Route::get('/',[TransacationController::class,'index'])->name('index');
        Route::get('/{invoice_number}',[TransacationController::class,'show'])->name('show');
        Route::get('/{invoice_number}/received',[TransacationController::class,'received'])->name('received');
        Route::get('/{invoice_number}/canceled',[TransacationController::class,'canceled'])->name('canceled');
        Route::get('/{invoice_number}/expired',[TransacationController::class,'expired'])->name('expired');
        Route::get('/expiredmidtrans',[TransacationController::class,'expiredMidtrans'])->name('expiredmidtrans');
        Route::get('/success',[TransacationController::class,'success'])->name('success');
        Route::post('/metodePembayaran',[TransacationController::class,'metodePembayaran'])->name('metodePembayaran');
        Route::post('/updatePembayaranManual',[TransacationController::class,'updatePembayaranManual'])->name('updatePembayaranManual');
        Route::get('/getstatus/{invoice_number}',[TransacationController::class,'getOrderStatus'])->name('getOrderStatus');
    });    
});
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/product_list', [FrontendProductController::class,'index'])->name('product.index');
Route::get('/category', [FrontendCategoryController::class,'index'])->name('category.index');
Route::get('/category/{slug}', [FrontendCategoryController::class,'show'])->name('category.show');


Route::get('/product/{categoriSlug}/{productSlug}',[FrontendProductController::class,'show'])->name('product.show');

Route::post('/notifikasi',function(){
    Notification::route('telegram', env('TELEGRAM_CHAT_ID'))->notify(new Notificationtele);
});

Route::get('/print-pdf/{invoice_number}', [PrintController::class, 'printPDF'])->name('print.pdf');

require __DIR__ . '/auth.php';
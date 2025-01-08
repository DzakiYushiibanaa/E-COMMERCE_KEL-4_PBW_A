<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home/productdetail/{id}', [HomeController::class, 'productDetail'])->name('home/productdetail');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('category.show');

Route::get('/fetch-products', [HomeController::class, 'fetchProducts'])->name('fetch.products');



// Halaman untuk menambahkan produk ke keranjang, harus login terlebih dahulu
Route::post('/add_cart/{id}', [HomeController::class, 'add_cart'])
    ->middleware('auth')
    ->name('addCart/product');


//Route untuk menampilkan keranjang pengguna
Route::middleware('auth', 'user')->group(function () {
    

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    // Route::post('/cart/add', [CartController::class, 'add']);
    // Memperbarui jumlah produk di dalam keranjang
    Route::put('/cart/update/{cartItemId}', [CartController::class, 'update'])->name('cart.update');

    Route::post('/cart/update/{cartItemId}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    // Menghapus item dari keranjang
    Route::delete('/cart/remove/{cartItemId}', [CartController::class, 'remove'])->name('cart.remove');
    // Menampilkan halaman checkout

    
    Route::get('/cart/checkout', [CheckoutController::class, 'index'])->name('cart.checkout');
    // Proses checkout (misalnya untuk membuat pesanan)
    Route::post('/cart/checkoutprocess', [CheckoutController::class, 'processCheckout'])->name('cart.checkout.process');


    Route::get('/order/{order}/confirmation', [CheckoutController::class, 'confirmation'])->name('order.confirmation');



    Route::get('/search', [HomeController::class, 'search'])->name('search');


});



Route::middleware('auth', 'user')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{id}', [TransactionController::class, 'details'])->name('transaction.details');
    Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification'])->name('midtrans.notification');
    Route::get('/transactions/{orderId}/continue', [TransactionController::class, 'continuePayment'])->name('transactions.continue');



    // Route::post('/midtrans/webhook', [TransactionController::class, 'handleWebhook'])
    // ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
});

Route::post('/midtrans/webhook', [TransactionController::class, 'handleWebhook']);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//user
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


//admin
Route::middleware(['auth', 'admin'])->group(function (){
    Route::get('admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin/products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin/products/create');
    Route::post('/admin/products/store', [ProductController::class, 'store'])->name('admin/products/store');
    Route::get('/admin/products/update/{id}', [ProductController::class, 'update'])->name('admin/products/update');
    Route::post('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin/products/edit');
    Route::get('/admin/products/delete/{id}', [ProductController::class, 'delete'])->name('admin/products/delete');
    Route::post('/admin/products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('admin/products/bulkdelete');
    // Route untuk bulk update kategori atau bulk delete produk
    Route::post('/admin/products/bulkupdate', [ProductController::class, 'bulkUpdate'])->name('admin/products/bulkupdate');


    Route::resource('/admin/categories', CategoryController::class);
    Route::post('/admin/products/bulk-category', [ProductController::class, 'bulkCategoryUpdate'])->name('admin/products/bulk-category');

    // Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin/categories');



    // Menampilkan daftar pesanan
    Route::get('/orders/confirmations', [AdminController::class, 'orderList'])->name('orders.list');

    // Menampilkan detail pesanan
    Route::get('/orders/{id}/details', [AdminController::class, 'showOrder'])->name('orders.details');

    // Update status pengiriman pesanan
    Route::put('/orders/{id}/update-status', [AdminController::class, 'updateOrderStatus'])->name('orders.update');







    Route::get('/admin/reports/sales', [SalesReportController::class, 'index'])->name('sales.report');





    Route::resource('promos', PromoController::class);

});

Route::get('auth/{provider}', [SocialLoginController::class, 'redirect'])->name('auth.redirect');
Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback'])->name('auth.callback');

require __DIR__.'/auth.php';


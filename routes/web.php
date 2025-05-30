<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ProductListController;
use App\Http\Controllers\User\UserController;
use App\Models\Brand;

//user routers
Route::get('/', [UserController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//
//cart
Route::prefix('cart')->controller(CartController::class)->group(
    function () {
        Route::get('view', 'index')->name('cart.view');
        Route::post('store/{product}', 'store')->name('cart.store');
        Route::patch('update/{product}', 'update')->name('cart.update');
        Route::delete('delete/{product}', 'destroy')->name('cart.delete');
    }
);
//product
Route::prefix('products')->controller(ProductListController::class)->group(
    function () {
        Route::get('/', 'index')->name('products.index');
    }
);
//check out
Route::prefix('checkout')->controller(CheckoutController::class)->group(
    function () {
        Route::post('order', 'store')->name('checkout.store');
        Route::get('success', 'success')->name('checkout.success');
        Route::get('cancel', 'cancel')->name('checkout.cancel');
    }
);
//admin router
Route::group(['prefix' => 'admin', 'middleware' => 'redirectAdmin'], function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.post');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/products', [ProductsController::class, 'index'])->name('admin.products.index');
    Route::post('/products/store', [ProductsController::class, 'store'])->name('admin.products.store');
    Route::put('/products/update/{id}', [ProductsController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/image/{id}', [ProductsController::class, 'deleteImage'])->name('admin.products.images.delete');
    Route::delete('products/destory/{id}', [ProductsController::class, 'destory'])->name('admin.products.destory');
    Route::get('/categories', [CategoriesController::class, 'index'])->name('admin.categories.index');
    Route::get('/brands', [BrandsController::class, 'index'])->name('admin.brands.index');
});
//end

require __DIR__ . '/auth.php';

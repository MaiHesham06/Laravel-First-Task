<?php

use App\Http\Controllers\Web\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Web\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Web\Admin\ProductVariantController as AdminProductVariantController;
use App\Http\Controllers\Web\Admin\UserController as AdminUserController;
use App\Http\Controllers\Web\RatingController;
use App\Http\Controllers\Web\BrandController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::check()) {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return $user->isAdmin()
            ? redirect()->route('admin.users.index')
            : redirect()->route('web.users.profile');
    }
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/categories',                 [CategoryController::class, 'index'])->name('web.categories.index');
    Route::get('/categories/{category}',      [CategoryController::class, 'show'])->name('web.categories.show');
    Route::get('/products',                   [ProductController::class, 'index'])->name('web.products.index');
    Route::get('/products/{product}',         [ProductController::class, 'show'])->name('web.products.show');
    Route::post('/products/{product}/rate',   [RatingController::class, 'store'])->name('web.products.rate');
    Route::delete('/products/{product}/rate', [RatingController::class, 'destroy'])->name('web.products.rate.destroy');
    Route::get('/brands',                     [BrandController::class, 'index'])->name('web.brands.index');
    Route::get('/brands/{brand}',             [BrandController::class, 'show'])->name('web.brands.show');

    Route::get('/profile',      [UserController::class, 'profile'])->name('web.users.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('web.users.edit');
    Route::put('/profile',      [UserController::class, 'update'])->name('web.users.update');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/products',                                    [AdminProductController::class, 'index'])->name('products.index');

        Route::get('/brands',                 [AdminBrandController::class, 'index'])->name('brands.index');
        Route::post('/brands',                [AdminBrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}/edit',    [AdminBrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brand}',         [AdminBrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}',      [AdminBrandController::class, 'destroy'])->name('brands.destroy');

        Route::get('/categories',                                    [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories',                                   [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}',                         [AdminCategoryController::class, 'show'])->name('categories.show');
        Route::get('/categories/{category}/edit',                    [AdminCategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}',                         [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}',                      [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/categories/{category}/products',               [AdminCategoryController::class, 'storeProduct'])->name('products.store');
        Route::delete('/products/{product}/images/{image}',          [AdminCategoryController::class, 'destroyImage'])->name('products.images.destroy');
        Route::post('/products/{product}/variants',                  [AdminProductVariantController::class, 'store'])->name('products.variants.store');
        Route::delete('/products/{product}/variants/{variant}',      [AdminProductVariantController::class, 'destroy'])->name('products.variants.destroy');Route::delete('/categories/{category}/products/{product}',   [AdminCategoryController::class, 'destroyProduct'])->name('products.destroy');
        Route::get('/categories/{category}/products/{product}/edit', [AdminCategoryController::class, 'editProduct'])->name('products.edit');
        Route::put('/categories/{category}/products/{product}',      [AdminCategoryController::class, 'updateProduct'])->name('products.update');

        Route::get('/users',                 [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',          [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit',     [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',          [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',       [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore')->withTrashed();
    });
});

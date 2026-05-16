<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\Admin\UserController as AdminUserController;
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

    Route::get('/profile', [UserController::class, 'profile'])->name('web.users.profile');

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users',                 [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}',          [AdminUserController::class, 'show'])->name('users.show');
        Route::get('/users/{user}/edit',     [AdminUserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}',          [AdminUserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',       [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{user}/restore', [AdminUserController::class, 'restore'])->name('users.restore')->withTrashed();
    });
});

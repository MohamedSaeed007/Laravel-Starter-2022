<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'as' => 'admin.',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        Route::middleware(['auth', 'role:owner'])->group(function () {
            Route::get('/home', [HomeController::class, 'index'])->name('home');
            Route::view('about', 'about')->name('about')->middleware('auth');

            Route::get('users', [UserController::class, 'index'])->name('users.index');

            Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
            Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        });
    }
);

<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', LoginController::class)->name('login');
Route::post('register', RegisterController::class)->name('register');

Route::controller(PostController::class)->prefix('posts-frontend')->name('posts-frontend.')->group(function () {
    Route::get('/', 'allFrontend')->name('index');
    Route::get('/newest', 'newestFrontend')->name('newest');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(PostCategoryController::class)->prefix('post-categories')->name('post-categories.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{postCategory}', 'find')->name('find');
        Route::post('/', 'store')->name('store');
        Route::patch('/{postCategory}', 'update')->name('update');
        Route::delete('/{postCategory}', 'destroy')->name('destroy');
    });

    Route::controller(PostController::class)->prefix('posts')->name('posts.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{post}', 'find')->name('find');
        Route::post('/', 'store')->name('store');
        Route::patch('/{post}', 'update')->name('update');
        Route::delete('/{post}', 'destroy')->name('destroy');
        Route::patch('/toggle-active/{post}', 'toggleActive')->name('toggle-active');
    });

    Route::controller(BookmarkController::class)->prefix('bookmarks')->name('bookmarks.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{post}', 'store')->name('store');
        Route::delete('/{post}', 'destroy')->name('destroy');
    });

    Route::controller(UserController::class)->prefix('users')->name('users.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'find')->name('find');
        Route::post('/', 'store')->name('store');
        Route::patch('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
    });

    Route::post('logout', LogoutController::class)->name('logout');
});

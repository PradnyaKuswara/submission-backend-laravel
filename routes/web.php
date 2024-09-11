<?php

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('pages.index');
})->name('index');

Route::get('/blogs', function (): View {
    return view('pages.blog.index');
})->name('blogs.index');

Route::get('/blogs/{post}', function (Post $post): View {
    return view('pages.blog.detail', [
        'post' => $post
    ]);
})->name('blogs.detail');

Route::get('/login', function (): View {
    return view('pages.auth.login');
})->name('login-page');

Route::get('/register', function (): View {
    return view('pages.auth.register');
})->name('register-page');

Route::get('/manage/blog/category', function (): View {
    return view('pages.manage-blog-category.index');
})->name('manage.blogs.category.index');
Route::get('/manage/blog/category/create', function (): View {
    return view('pages.manage-blog-category.create');
})->name('manage.blogs.category.create');
Route::get('/manage/blog/category/edit/{postCategory}', function (PostCategory $postCategory): View {
    return view('pages.manage-blog-category.edit', [
        'postCategory' => $postCategory
    ]);
})->name('manage.blogs.category.edit');

Route::get('/manage/blog/', function (): View {
    return view('pages.manage-blog.index');
})->name('manage.blogs.index');
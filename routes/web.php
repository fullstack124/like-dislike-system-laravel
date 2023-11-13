<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'index')->name('auth.register');
    Route::post('/create/register', 'create')->name('user.make.register');
    Route::get('/login', 'login_view')->name('auth.login');
    Route::post('/user/login', 'login')->name('user.login');
});

Route::middleware(['auth'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->name('auth.logout'); 
    });
    
    Route::controller(PostController::class)->group(function () {
        Route::get('/', 'index')->name('user.post');
        Route::get('/posts/all', 'show_all_posts')->name('user.posts.all');
        Route::post('/posts/like', 'like_post')->name('user.posts.like');
        Route::post('/posts/dis_like', 'dis_like_post')->name('user.posts.dis_like');
        Route::post('/comment/all', 'show_comments')->name('user.comment.all');
        Route::post('/comment/create', 'create_comments')->name('user.comment.create');
        Route::post('/comment/replay/all', 'show_replay_comments')->name('user.comment.replay.all');
        Route::post('/comment/create/replay', 'create_replay_comments')->name('user.comment.create.replay.all');
    });
    
});
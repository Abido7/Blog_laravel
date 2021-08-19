<?php

use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(
    function () {
        Route::get('/', [MainPageController::class, 'index']);;

        Route::resource('/profile', ProfileController::class)->only(['index', 'show', 'update']);

        Route::get('followings/{user}', [ProfileController::class, 'followings']);
        Route::get('followers/{user}', [ProfileController::class, 'followers']);
        Route::delete('unfollow', [ProfileController::class, 'unfollow']);
        Route::post('/follow', [ProfileController::class, 'follow']);

        Route::resource('post', PostController::class)->only(['store', 'update', 'destroy', 'show']);

        Route::post('/add-comment/{id}', [CommentController::class, 'store']);
        Route::post('post/like', [LikeController::class, 'like']);
        Route::delete('post/dislike/{post}', [LikeController::class, 'unlike']);
    }
);

Route::prefix('/dashboard')->middleware(['isAdmin'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::patch('/toggle-status/{user}', [UserController::class, 'toggleStatus']);
});


require __DIR__ . '/auth.php';
<?php

use App\Http\Controllers\admin\CommentController as AdminCommentController;
use App\Http\Controllers\admin\HomeController as AdminHomeController;
use App\Http\Controllers\admin\LikeController as AdminLikeController;
use App\Http\Controllers\admin\PostController as AdminPostController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowingController;
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

        Route::get('followings/{user}', [FollowingController::class, 'followings']);
        Route::get('followers/{user}', [FollowingController::class, 'followers']);

        Route::resource('/follow/user', FollowingController::class)->only(['store', 'destroy']);


        Route::resource('post', PostController::class)->only(['store', 'update', 'destroy', 'show']);

        Route::post('/add-comment/{id}', [CommentController::class, 'store']);
        Route::post('post/like', [LikeController::class, 'like']);
        Route::delete('post/dislike/{post}', [LikeController::class, 'unlike']);
    }
);

Route::prefix('/dashboard')->middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('/', [AdminHomeController::class, 'index'])->name('dashboard');

    Route::get('/users/info', [UserController::class, 'info']);
    Route::resource('/users', UserController::class)->only(['index', 'show', 'destroy']);

    // toggle status
    Route::patch('user/activate/{user}', [UserController::class, 'active']);
    Route::patch('user/deactivate/{user}', [UserController::class, 'deactive']);
    // toggle role
    Route::patch('user/promote/{user}', [UserController::class, 'promote']);
    Route::patch('user/demote/{user}', [UserController::class, 'demote']);


    Route::resource('/posts', AdminPostController::class)->only(['index', 'destroy']);
    Route::get('/posts/info', [AdminPostController::class, 'info']);
});


require __DIR__ . '/auth.php';
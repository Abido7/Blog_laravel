<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', [MainPageController::class, 'index'])->middleware('auth');;
Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::get('followings/{user}', [ProfileController::class, 'followings'])->middleware(['auth', "Isprivate"]);
Route::get('/user/{user}', [ProfileController::class, 'showUser']);
Route::get('/post/{id}', [PostController::class, 'postDetails'])->middleware('auth');
Route::post('/post/store', [PostController::class, 'store'])->middleware('auth');
Route::delete('/post/delete', [PostController::class, 'delete'])->middleware('auth');
// Route::get('/post/comments/{comment}', [PostController::class, 'showComment'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
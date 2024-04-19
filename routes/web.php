<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    //Route::get('/dashboard', function () {
      //  return view('dashboard');
    //})->name('dashboard');

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('profile', [UserController::class, 'getUserData'])
    ->name('profile');

    Route::get('edit-profile', [UserController::class, 'editUser'])
    ->name('settings');

    Route::post('update-user-settings', [UserController::class, 'update'])
    ->name('update.user');

    Route::post('update-user-password', [UserController::class, 'updateUserPassword'])
    ->name('change.password');

    Route::get('user-posts', [UserController::class, 'userPosts'])
    ->name('user-posts');

    Route::get('update-post-by-user/{user_id}/{post_id}', [UserController::class, 'notificationReadByUser'])
    ->name('post.update.user.page');
});

Route::get('posts', [PostsController::class, 'getAll'])
    ->name('posts');

Route::get('post-page', [PostsController::class, 'creatPostPage'])
    ->name('post.create.page');

Route::post('add-post', [PostsController::class, 'createPost'])
->name('create.post');

Route::get('edit-post/{id}', [PostsController::class, 'edit'])
->name('edit.post');

Route::post('update-post', [PostsController::class, 'update'])
->name('update.post');

/**********************User *******************************/
Route::get('all-users', [UserController::class, 'getAll'])
->name('all.users');

Route::get('imporsonate-user/{id}', [UserController::class, 'imporsonateUser'])
->name('imporsonate.user');

Route::get('update-post-user/{user_id}/{post_id}', [UserController::class, 'notificationRead'])
->name('post.update.user');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\CommentController;
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
require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';

Route::get('/', function () {
    return redirect()->route('posts.index');
})->name('blog-home');

Route::resource('posts', PostController::class);

Route::post('comments/{post}', [CommentController::class, 'store'])->name('comments.store');

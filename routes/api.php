<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// public route for viewing posts
Route::get('posts', [PostController::class, 'showAllPosts']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // posts
    Route::post('/posts', [PostController::class, 'createPost']);
    Route::patch('/posts/{post}', [PostController::class, 'editPost']);
    Route::delete('/posts/{post}', [PostController::class, 'deletePost']);

    // show all the posts (published by defualt, drafts when the query parameter is present.)
    Route::get('/posts/with-drafts', [PostController::class, 'showAllDraftsandPublished']);
    

    // comments
    Route::post('/posts/{post}/comments ', [CommentController::class, 'createComment']);
    Route::patch('/comments/{comment}', [CommentController::class, 'updateComment']);
    Route::delete('/comments/{comment}', [CommentController::class, 'deleteComment']);

});


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
Route::get('show-all-posts', [PostController::class, 'showAllPosts']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // posts
    Route::post('create-post', [PostController::class, 'createPost']);
    Route::post('edit-post/{post}', [PostController::class, 'editPost']);
    Route::delete('delete-post/{post}', [PostController::class, 'deletePost']);

    // show all the posts (published by defualt, drafts when the query parameter is present.)
    Route::get('show-all-drafts-and-published-posts', [PostController::class, 'showAllDraftsandPublished']);
    

    // comments
    Route::post('posts/{post}/create-comment', [CommentController::class, 'createComment']);
    Route::put('/update-comment/{comment}', [CommentController::class, 'updateComment']);
    Route::delete('/delete-comment/{comment}', [CommentController::class, 'deleteComment']);

});


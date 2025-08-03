<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;


Route::middleware('throttle:custom_api_limiter')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // public route for listing all the published posts
    Route::get('posts', [PostController::class, 'index']);
    // public route for viewing post by ID
    Route::get('posts/{post}', [PostController::class, 'show']);

    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [AuthController::class, 'reset']);


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::patch('/profile', [AuthController::class, 'updateProfile']);

        // posts
        Route::middleware(['role:author,admin'])->group(function () {
            Route::post('/posts', [PostController::class, 'store']);
            Route::patch('/posts/{post}', [PostController::class, 'update']);
            Route::delete('/posts/{post}', [PostController::class, 'destroy']);
        });
        
        //publish posts
        Route::patch('/posts/{post}/publish', [PostController::class, 'publishPost']);

        // get all published posts by any user and draft posts by authenticated user
        Route::get('/posts-with-drafts', [PostController::class, 'indexWithDrafts']);
        

        // comments
        Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
        Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
        Route::get('/posts/{post}/comments/{comment}', [CommentController::class, 'show']);
        Route::patch('/comments/{comment}', [CommentController::class, 'update']);
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    });

});
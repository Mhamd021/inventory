<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentApiController;
use App\Http\Controllers\FriendsApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostApiController;
use App\Http\Controllers\JourneyApiController;
use App\Http\Controllers\LikeApiController;

//auth
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('ensure_frontend_requests_are_stateful', 'auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //posts
    Route::post('ModifyPost/{post}', 'App\Http\Controllers\PostApiController@ModifyPost');
    //likes
    Route::middleware('auth')->group(function ()
    {
        Route::apiResource('posts', PostApiController::class);
        Route::post('apiPosts/like/{postId}', [LikeApiController::class, 'toggleLike']);
        Route::get('apiPosts/{post}/comments', [PostApiController::class, 'getComments']);
        Route::get('apiPosts/{post}/comment-count', [PostApiController::class, 'getCommentCount']);
        Route::get('apiPosts/{post}/likes-count', [PostApiController::class, 'getLikesCount']);

    });

    Route::get('hasliked/{post}', 'App\Http\Controllers\LikeApiController@hasLiked');
    Route::get('userlikes/{user}', 'App\Http\Controllers\LikeApiController@userlikes');
    //comments
    Route::apiResource('comments', CommentApiController::class);
    Route::post('ModifyComment/{comment}', 'App\Http\Controllers\CommentApiController@ModifyComment');
    //friends
    Route::apiResource('friends', FriendsApiController::class);
});
//auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//journeys

Route::get('/journeys', [JourneyApiController::class , 'index']);
Route::get('/journey/{journey}', [JourneyApiController::class , 'show']);

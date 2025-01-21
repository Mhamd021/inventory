<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\AuthController;

//auth
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('ensure_frontend_requests_are_stateful', 'auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    //posts
    Route::apiResource('posts', PostController::class);
    Route::post('ModifyPost/{post}', 'App\Http\Controllers\PostController@ModifyPost');
    //post comments
    Route::get('postcomments/{post}', 'App\Http\Controllers\CommentController@postcomments');

    //likes
    Route::get('hasliked/{post}', 'App\Http\Controllers\LikeController@hasLiked');
    Route::post('like', 'App\Http\Controllers\LikeController@store');
    Route::get('postlikes/{post}', 'App\Http\Controllers\LikeController@postlikes');
    Route::get('userlikes/{user}', 'App\Http\Controllers\LikeController@userlikes');
    Route::delete('like/{like}', 'App\Http\Controllers\LikeController@destroy');
    Route::get('likes', 'App\Http\Controllers\PostController@likes');

    //comments
    Route::apiResource('comments', CommentController::class);
    Route::post('ModifyComment/{comment}', 'App\Http\Controllers\CommentController@ModifyComment');
    //friends
    Route::apiResource('friends', FriendController::class);
});


//auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//journeys

Route::get('/journeys', 'App\Http\Controllers\JourneyController@apijourney');
Route::get('/journey/{journey}', 'App\Http\Controllers\JourneyController@showjourneyapi');

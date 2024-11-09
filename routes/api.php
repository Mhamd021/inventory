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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('hasliked/{post}', 'App\Http\Controllers\LikeController@hasLiked');
    Route::post('like', 'App\Http\Controllers\LikeController@store');
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//friends
Route::apiResource('friends', FriendController::class);

//posts
Route::get('postcomments/{post}', 'App\Http\Controllers\CommentController@postcomments');
Route::post('ModifyPost/{post}', 'App\Http\Controllers\PostController@ModifyPost');
Route::apiResource('posts', PostController::class);


//comments
Route::apiResource('comments', CommentController::class);
Route::post('ModifyComment/{comment}', 'App\Http\Controllers\CommentController@ModifyComment');

//likes
Route::get('postlikes/{post}', 'App\Http\Controllers\LikeController@postlikes');
Route::get('userlikes/{user}', 'App\Http\Controllers\LikeController@userlikes');
Route::delete('like/{like}', 'App\Http\Controllers\LikeController@destroy');
Route::get('likes', 'App\Http\Controllers\PostController@likes');

//journeys
Route::get('/journeys', 'App\Http\Controllers\JourneyController@apijourney');
Route::get('/journey/{journey}', 'App\Http\Controllers\JourneyController@showjourneyapi');

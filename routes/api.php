<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('postcomments/{post}','App\Http\Controllers\CommentController@postcomments');
Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('friends', FriendController::class);

Route::get('/journeys','App\Http\Controllers\JourneyController@apijourney');
Route::get('/journey/{journey}','App\Http\Controllers\JourneyController@showjourneyapi');



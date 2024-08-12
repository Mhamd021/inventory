<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JourneyController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/journeys','App\Http\Controllers\JourneyController@apijourney');
Route::get('/journey/{journey}','App\Http\Controllers\JourneyController@showjourneyapi');



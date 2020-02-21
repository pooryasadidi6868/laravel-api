<?php

use Illuminate\Http\Request;


Route::get('test', function () {
    return response('Hello World', 200)
        ->header('Content-Type', 'text/plain');
});

Route::post('register','Api\Auth\AuthController@register');
Route::post('login','Api\Auth\AuthController@login');
Route::get('logout','Api\Auth\AuthController@logout');
Route::get('user','Api\Auth\AuthController@user');
// topic crud

Route::apiResource('topics','Api\TopicController')->middleware('auth:api');

//posts crud

Route::apiResource('posts','Api\PostController')->middleware('auth:api');

Route::get("me",function (){
    return response()->json([
        "name"=>"dasfasdf"
    ]);
});
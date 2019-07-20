<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login','Android@login');

Route::post('master/user/add','Android@add');

Route::post('master/vote/add','Android@masterVote');

Route::post('master/url','Android@masterUrl');

Route::post('vote/kepuasan-pelanggan','Android@vote');

Route::post('image','Android@image');

Route::post('master/area','Android@getArea');

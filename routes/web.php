<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('dashboard/login','Dashboard@login');
Route::post('dashboard/login/check','Dashboard@loginCheck');

Route::get('dashboard','Dashboard@index');

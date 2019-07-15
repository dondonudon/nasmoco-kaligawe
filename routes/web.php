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

Route::get('dashboard/login','Dashboard@login')->name('dashboard_login');
Route::post('dashboard/login/check','Dashboard@loginCheck');

Route::get('dashboard','Dashboard@index')->name('dashboard');

Route::get('dashboard/system/menu','SystemMenu@index')->name('system_menu');
Route::get('dashboard/system/menu/list','SystemMenu@list');
Route::get('dashboard/system/menu/list/group','SystemMenu@group');
Route::post('dashboard/system/menu/add','SystemMenu@add');
Route::post('dashboard/system/menu/edit','SystemMenu@edit');

Route::get('dashboard/system/menu-group','SystemGroupMenu@index')->name('system_menu_group');
Route::get('dashboard/system/menu-group/list','SystemGroupMenu@list');
Route::post('dashboard/system/menu-group/add','SystemGroupMenu@add');
Route::post('dashboard/system/menu-group/edit','SystemGroupMenu@edit');

Route::get('dashboard/master/user','MasterUser@index')->name('master_user');
Route::get('dashboard/master/user/list','MasterUser@list');
Route::post('dashboard/master/user/permission','MasterUser@permission');
Route::post('dashboard/master/user/new','MasterUser@new');
Route::post('dashboard/master/user/edit','MasterUser@edit');

Route::get('dashboard/master/vote','MasterVote@index')->name('master_vote');
Route::get('dashboard/master/vote/list','MasterVote@list');
Route::post('dashboard/master/vote/add','MasterVote@add');
Route::post('dashboard/master/vote/edit','MasterVote@edit');

Route::get('dashboard/master/profile','MasterProfile@index')->name('master_profile');
Route::get('dashboard/master/profile/detail','MasterProfile@detail');
Route::post('dashboard/master/profile/edit','MasterProfile@edit');

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
Route::get('dashboard/logout','Dashboard@sessionFlush');

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

Route::get('dashboard/master/set-url-survey','MasterUrlVoting@index')->name('master_url_voting');
Route::post('dashboard/master/set-url-survey/edit','MasterUrlVoting@edit');
Route::post('dashboard/master/set-url-survey/detail','MasterUrlVoting@detail');

Route::get('dashboard/voting/kepuasan-pelanggan','VoteKepuasanPelanggan@index')->name('voting_kepuasan_pelanggan');
Route::post('dashboard/voting/kepuasan-pelanggan/list','VoteKepuasanPelanggan@list');

Route::get('dashboard/master/area','MasterArea@index')->name('master_area');
Route::get('dashboard/master/area/list','MasterArea@list');
Route::post('dashboard/master/area/add','MasterArea@add');
Route::post('dashboard/master/area/edit','MasterArea@edit');

Route::get('dashboard/master/image','MasterImage@index')->name('master_image');
Route::get('dashboard/master/image/list','MasterImage@list');
Route::post('dashboard/master/image/add/{id_area}','MasterImage@add');
Route::post('dashboard/master/image/edit','MasterImage@edit');

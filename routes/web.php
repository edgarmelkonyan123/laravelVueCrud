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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::resource('section', 'SectionController')->except(['show']);
    Route::get('getSections', 'SectionController@getSections');
    Route::get('getSection/{id}', 'SectionController@getSection');


    Route::resource('user', 'UserController')->except(['show']);
    Route::get('getAllUsers', 'UserController@getAllUsers');
    Route::get('getUsers', 'UserController@getUsers');
    Route::get('getUser/{id}', 'UserController@getUser');
});

Route::get('/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->where('locale', '(en|ru)');;

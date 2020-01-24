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


Auth::routes();

Route::get('/', 'PublicController@index');


// заглушка отменяющая регистрацию с сайта
Route::match(['post', 'get'], 'register', function () {
    Auth::logout();

    return redirect('/');
})->name('register');


Route::middleware('auth')->group(function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('project-data/create', 'ProjectDataController@create')->name('project-data.create');
    Route::get('project-data/list', 'ProjectDataController@list')->name('project-data.list');
    Route::post('project-data/save', 'ProjectDataController@save')->name('project-data.save');

    //	Route::get('user/{telegram_user_id}', 'HomeController@user')->name('users.show');
});



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

// партнеры
Route::middleware('auth')->group(function () {
	Route::get('home', 'HomeController@index')->name('home');

	Route::get('my-projects', 'PartnersController@userTargets')->name('my-projects');

	Route::get('project-data/create', 'ProjectDataController@create')->name('project-data.create');
	Route::get('project-data/list', 'ProjectDataController@list')->name('project-data.list');
	Route::post('project-data/save', 'ProjectDataController@save')->name('project-data.save');
});

// админы
Route::middleware('auth', 'admin')->group(function () {
	// каналы
	Route::resource('channels', 'ChannelsController');

	// проекты
	Route::get('projects/statuses', 'ProjectsController@targets')->name('projects.statuses');

	Route::resource('projects', 'ProjectsController');
	Route::post('projects/{id}/addsubproject', 'ProjectsController@addSubProject')->name('projects.addsubproject');

	// партнеры
	Route::resource('partners', 'PartnersController');
	Route::post('partners/{id}/addsubproject', 'PartnersController@addUserSubProject')->name('partners.addsubproject');
});
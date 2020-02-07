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
	Route::get('user-target-data/index', 'UserTargetDataController@index')->name('user-target-data.index');
	Route::get('user-target-data/create', 'UserTargetDataController@create')->name('user-target-data.create');
	Route::get('user-target-data/list', 'UserTargetDataController@list')->name('user-target-data.list');
	Route::post('user-target-data/save', 'UserTargetDataController@save')->name('user-target-data.save');

	Route::get('/cities/list', 'CitiesController@list')->name('cities.list');
	Route::get('/sub-projects/list', 'SubProjectsController@list')->name('sub-projects.list');
	Route::get('/channels/list', 'ChannelsController@list')->name('channels.list');

	Route::post('/reports/main', 'ReportsController@main')->name('reports.main');

	Route::get('my-projects', 'PartnersController@userTargets')->name('user-targets');
	Route::post('my-projects', 'PartnersController@userTargetUpdate')->name('user-targets.update');
});

// админы
Route::middleware('auth', 'admin')->group(function () {
	// каналы
	Route::resource('channels', 'ChannelsController');

	// проекты
	Route::get('projects/statuses', 'ProjectsController@targets')->name('projects.statuses');

	Route::resource('projects', 'ProjectsController');
	Route::post('projects/{id}/subproject/add', 'ProjectsController@addSubProject')->name('projects.addsubproject');
	Route::post('projects/{id}/subproject/delete', 'ProjectsController@deleteSubProject');

	// партнеры
	Route::get('partners/list', 'PartnersController@list')->name('partners.list');
	Route::resource('partners', 'PartnersController');
	Route::post('partners/{id}/addsubproject', 'PartnersController@addUserSubProject')->name('partners.addsubproject');
});
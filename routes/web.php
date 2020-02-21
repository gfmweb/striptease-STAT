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
	Route::get('user-target-data/create', 'UserTargetDataController@create')->name('user-target-data.create');
	Route::get('user-target-data/list', 'UserTargetDataController@list')->name('user-target-data.list');
	Route::post('user-target-data/save', 'UserTargetDataController@save')->name('user-target-data.save');

	Route::get('/cities/list', 'CitiesController@list')->name('cities.list');
	Route::get('/tags/list', 'TagsController@list')->name('tags.list');
	Route::get('/sub-projects/list', 'SubProjectsController@list')->name('sub-projects.list');
	Route::get('/projects/list', 'ProjectsController@list')->name('projects.list');
	Route::get('/channels/list', 'ChannelsController@list')->name('channels.list');

	Route::get('/reports/main', 'ReportsController@mainReport')->name('reports.main');
	Route::post('/reports/main/data', 'ReportsController@mainReportData')->name('reports.main.data');

	Route::get('my-projects', 'ProjectsController@myProjects')->name('my-projects');
	Route::post('my-projects/target-update', 'ProjectsController@myProjectTargetUpdate')->name('my-projects.update');
	Route::get('my-projects/{subProjectId}/channels', 'ProjectsController@myProjectChannels')->name('my-projects.channels');
	Route::get('my-projects/{subProjectId}/channels/edit', 'ProjectsController@myProjectChannelsEdit')->name('my-projects.channels.edit');
	Route::post('my-projects/{subProjectId}/channels/update', 'ProjectsController@myProjectChannelsUpdate')->name('my-projects.channels.update');

});

// админы
Route::middleware('auth', 'admin')->group(function () {
	// каналы
	Route::resource('channels', 'ChannelsController');

	// проекты
	Route::get('projects/statuses', 'ProjectsController@targets')->name('projects.statuses');
	Route::resource('projects', 'ProjectsController');

	// подпроекты
	Route::post('projects/{project_id}/subproject/add', 'SubProjectsController@store')->name('projects.subproject.add');
	Route::get('projects/{project_id}/subproject/{sub_project_id}/edit', 'SubProjectsController@edit')->name('projects.subproject.edit');
	Route::post('projects/{project_id}/subproject/{sub_project_id}/update', 'SubProjectsController@update')->name('projects.subproject.update');
	Route::get('projects/{project_id}/subproject/{sub_project_id}/delete', 'SubProjectsController@destroy')->name('projects.subproject.delete');

	// партнеры
	Route::get('partners/list', 'PartnersController@list')->name('partners.list');
	Route::resource('partners', 'PartnersController');
	Route::post('partners/{id}/addsubproject', 'PartnersController@addUserSubProject')->name('partners.addsubproject');

	// пароли
	Route::resource('passwords', 'PasswordController');
	Route::post('password/{id}/addcity', 'PasswordCityController@create')->name('passwords.addcity');
});
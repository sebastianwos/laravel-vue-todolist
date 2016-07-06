<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('register/confirm/{token}', 'Auth\AuthController@confirmEmail');

Route::get('tasks', 'TasksController@index');
Route::get('api/tasks', 'TasksController@getTasks');
Route::post('api/task/status', 'TasksController@toggleStatus');
Route::delete('api/task', 'TasksController@deleteTask');
Route::put('api/task', 'TasksController@addTask');

Route::get('settings', 'SettingsController@index');
Route::post('settings', 'SettingsController@changePassword');
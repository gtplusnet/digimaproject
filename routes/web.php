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

Route::get('/', 'LoginController@to_login');
Route::get('/app', 'AppController@dashboard');
Route::get('/app/time_in', 'AppController@time_in');
Route::get('/app/time_out', 'AppController@time_out');
Route::get('/app/update_time_out', 'AppController@update_time_out');
Route::get('/app/add_task', 'AppController@add_task');
Route::post('/app/add_task', 'AppController@add_task_submit');
Route::get('/app/task_table', 'AppController@task_table');
Route::get('/app/view_task/{id}', 'AppController@view_task');
Route::get('/app/edit_task/{id}', 'AppController@edit_task');
Route::post('/app/edit_task/{id}', 'AppController@edit_task_submit');
Route::get('/app/member_list', 'AppController@member_list');
Route::get('/app/timesheet', 'AppController@timesheet');
Route::get('/app/update_task_status', 'AppController@update_task_status');
Route::get('/app/timesheet/table', 'AppController@timesheet_table');
Route::get('/app/count_for_review', 'AppController@count_for_review');
Route::post('/app/manual_time', 'AppController@manual_time');
Route::get('/app/review', 'AppController@review');
Route::get('/admin', 'AdminController@index');

Route::get('/login', 'LoginController@index');
Route::post('/login', 'LoginController@login_submit');
Route::get('/register', 'LoginController@register');
Route::post('/register', 'LoginController@register_submit');
Route::get('/logout', 'AppController@logout');
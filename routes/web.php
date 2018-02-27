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

Route::get('/', 'FrontController@login');
Route::get('/app', 'AppController@dashboard');
Route::get('/app/add_task', 'AppController@add_task');
Route::get('/app/view_task/{id}', 'AppController@view_task');
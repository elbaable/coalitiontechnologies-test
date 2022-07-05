<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@task');
Route::post('add-task', 'HomeController@add_task');
Route::post('update-task', 'HomeController@update_task');
Route::post('delete-task', 'HomeController@delete_task');
Route::post('update-priority', 'HomeController@update_priority');

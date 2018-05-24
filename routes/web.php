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

Route::get('/', 'WelcomeController@index')->name('index');
Route::get('php-internal', 'WelcomeController@phpInternal')->name('phpInternal');
Route::get('php', 'WelcomeController@php')->name('php');
Route::get('jscss', 'WelcomeController@jscss')->name('jscss');
Route::get('notes', 'WelcomeController@notes')->name('notes');
Route::get('licence', 'WelcomeController@licence')->name('licence');
Route::get('show/{path}', 'WelcomeController@show')->name('show');


Route::get('lists', 'WelcomeController@lists');
Route::get('test', 'WelcomeController@test');


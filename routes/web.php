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

Route::get('/', 'MainController@index')->name('home')->middleware('auth');
Route::get('/files/{type}/{id?}', 'FileController@fetchFile');

Route::post('files/add', 'FileController@addFile')->name('file-add');

Auth::routes();

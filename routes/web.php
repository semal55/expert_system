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

Route::get('/', "TestController@index")->name('index');

Route::get('/mkb', 'TestController@mkb')->name('mkb');
Route::post('/mkb', 'TestController@send')->name('send_test');

Route::get('/test/{test}', 'TestController@test')->name('test');
Route::post('/test/{test}', 'TestController@post_answer')->name('post_answer');
Route::get('result/{test}', 'TestController@result')->name('result');

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('employees', 'EmployeeController')->middleware('auth');

Route::get('datatables', 'DatatableController@anyData')->name('datatables.data');

Route::resource('positions', 'PositionController')->middleware('auth');

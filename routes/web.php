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

Route::get('datatables/positions', 'DatatableController@getPositions')->name('datatables.getPositions')->middleware('auth');;
Route::get('datatables/employees', 'DatatableController@getEmployees')->name('datatables.getEmployees')->middleware('auth');;
Route::get('employees/find{term?}', 'EmployeeController@find')->name('employees.find')->middleware('auth');

Route::resource('employees', 'EmployeeController')->middleware('auth');
Route::resource('positions', 'PositionController')->middleware('auth');

Route::get('check', function () {
  $result = \App\Employee::checkIerarchy(6) + \App\Employee::checkReverse(6);
  dump($result.' - $result');
});

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

Route::middleware(['auth'])->group(function () {
    Route::get('datatables/positions', 'DatatableController@getPositions')->name('datatables.getPositions');
    Route::get('datatables/employees', 'DatatableController@getEmployees')->name('datatables.getEmployees');
    Route::get('employees/find{term?}', 'EmployeeController@find')->name('employees.find');

    Route::resource('employees', 'EmployeeController');
    Route::resource('positions', 'PositionController');
});

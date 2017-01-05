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

Route::get('receipts/{year}/{period}/{sector}/{route}', 'ReceiptController@receipts');
//Route::resource('receipts', 'ReceiptController');

Route::get('github', function () {
	return \PDF::loadFile('http://www.github.com')->stream('github.pdf');
});
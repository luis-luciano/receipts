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
use App\Contract;

Route::get('/', function () {
	return view('welcome');
});

Route::resource('receipts', 'ReceiptController');

Route::get('test',function(){
	dd(Contract::searchContract(1208)->atrib==utf8_decode('año'));
});

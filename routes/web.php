<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;

Route::get('/', [ SmsController::class, 'index' ])->name('get.sms.form');

 
 
Route::get('send-sms', [ SmsController::class, 'index' ])->name('get.sms.form');
//Route::post('send-sms', [ SmsController::class, 'sendMessage' ])->name('send.sms');
Route::get('send-sms-bulk', [ SmsController::class, 'bulkView' ])->name('bulk.sms.form');
//Route::post('send-sms-bulk', [ SmsController::class, 'sendBulk' ])->name('send.sms.bulk');


Route::post('send-sms', [ SmsController::class, 'sendSingle' ])->name('send.sms');
Route::post('send-sms-bulk', [ SmsController::class, 'sendMany' ])->name('send.sms.bulk');



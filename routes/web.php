<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
 
 
Route::get('send-sms', [ SmsController::class, 'index' ])->name('get.sms.form');
Route::post('send-sms', [ SmsController::class, 'sendMessage' ])->name('send.sms');

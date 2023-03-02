<?php

use Illuminate\Http\Request;



Route::group(['prefix'=>'paypal'],function(){

    Route::post('/auth','PaypalController@auth')->name('authentication-paypal');
    Route::post('/order', 'PaypalController@create')->middleware('paypal')->name('create-paypal-order');
    Route::post('/order/capture', 'PaypalController@capture')->middleware('paypal')->name('capture-paypal-order');
    
});
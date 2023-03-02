<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

Route::group(['middleware' => ['api', 'jwt.verify'],'prefix'=>'user'],function(){

    Route::post('', [AuthController::class, 'register'])->middleware('permission')->name('add-user');

    Route::get('', 'UserController@index')->name('view-users');

    Route::put('/{user_id}/permission', 'UserController@updateUserPerm')->middleware('permission')->name('update-user-permission');

    Route::delete('/{user_id}', 'UserController@destroy')->middleware('permission')->name('delete-user');

    Route::put('/update-profile', 'UserController@updateProfile')->name('update-user-profile');

    Route::get('/{user_id}', 'UserController@showProfile')->name('view-user-profile');

    Route::post('/user-auto', 'UserController@userAuto')->name('autocomplete-user');

});

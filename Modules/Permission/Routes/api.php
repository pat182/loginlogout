<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['api', 'jwt.verify'],'prefix'=>'permission'],function(){

    Route::get('/', 'PermissionController@index')->name('view-permission-mtx');

    Route::post('/', 'PermissionController@create')->name('add-permission');

    Route::delete('/', 'PermissionController@removePermission')->name('remove-permission');

    Route::get('/{perm_id}', 'PermissionController@show')->name('view-permission');

    Route::post('/type', 'PermissionController@addType')->name('add-permission-type');

    Route::post('/group', 'PermissionController@addPermGroup')->name('add-permission-group');

    Route::delete('/type/{type_id}', 'PermissionController@deleteType')->name('delete-permission-type');
    
    Route::post('/permissions-auto', 'PermissionController@permAuto')->name('auto-complete-permission');

    
});
Route::post('permission/role-auto','PermissionController@roleAuto')->name('auto-complete-role');




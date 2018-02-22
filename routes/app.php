<?php

use Illuminate\Http\Request;

Route::group(['namespace' => 'Auth'], function(){

    Route::group(['namespace' => 'App'], function()
    {
    	Route::group(['middleware' => ['web']], function(){
	        
	        Route::get('register', 'RegisterController@showRegistrationForm');
	        Route::get('login', 'LoginController@showLoginForm');
		});
	
	   Route::post('register', 'RegisterController@register');
	   Route::post('login', 'LoginController@login');

       Route::get('regverifycode', 'RegisterController@getMobileVerifyCode');
       Route::get('logverifycode', 'LoginController@getMobileVerifyCode');
    });
});
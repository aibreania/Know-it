<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
function user_ins() {
  return new App\User;
}

Route::get('/', function () {
    return view('welcome');
});

Route::any('api', function(){
    return ['version' => 0.1];
});

Route::any('api/signup', function(){
    return user_ins()->signup();
});

Route::any('api/login', function(){
    return user_ins()->login();
});

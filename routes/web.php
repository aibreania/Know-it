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
function rq($key=null, $default=null)
{
  if(!$key) return Request::all();
  return Request::get($key, $default);
}

function user_ins() {
  return new App\User;
}

function question_ins() {
  return new App\Question;
}

function answer_ins() {
  return new App\Answer;
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

Route::any('api/logout', function(){
    return user_ins()->logout();
});

Route::any('api/question/add', function(){
    return question_ins()->add();
});

Route::any('api/question/change', function(){
    return question_ins()->change();
});

Route::any('api/question/read', function(){
    return question_ins()->read();
});

Route::any('api/question/remove', function(){
    return question_ins()->remove();
});

Route::any('api/answer/add', function(){
    return answer_ins()->add();
});

Route::any('api/answer/change', function(){
    return answer_ins()->change();
});

Route::any('api/answer/read', function(){
    return answer_ins()->read();
});

Route::any('test', function(){
    dd(user_ins()->is_logged_in());
});

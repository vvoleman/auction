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
Route::get('/login',"LoginController@getLogin")->name("login.index");
Route::post('/login',"LoginController@postLogin")->name("login.postLogin");
Route::get('/register',"RegisterController@getRegister")->name("register.index");
Route::post('/register',"RegisterController@postRegister")->name("register.postRegister");

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
})->name('home.home');
Route::get('/login',"LoginController@getLogin")->name("login.index");
Route::post('/login',"LoginController@postLogin")->name("login.postLogin");
Route::get('/register',"RegisterController@getRegister")->name("register.index");
Route::post('/register',"RegisterController@postRegister")->name("register.postRegister");

Route::get('/activate/{token}',"ActivationController")->name('activate.activate')->where('token','[A-Za-z0-9]+');

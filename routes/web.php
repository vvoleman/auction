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

Route::get('/',"HomeController@getHome")->name('home.home');

//LOGIN
Route::get('/login',"LoginController@getLogin")->name("login.login")->middleware('notauth');
Route::post('/login',"LoginController@postLogin")->name("login.postLogin")->middleware('notauth');
Route::get('/logout',"LoginController@getLogout")->name('login.logout')->middleware('auth');

//REGISTER
Route::get('/register',"RegisterController@getRegister")->name("register.register")->middleware('notauth');
Route::post('/register',"RegisterController@postRegister")->name("register.postRegister")->middleware('notauth');

//FORGOT PASSWORD
Route::get('/forgot',"ForgotPasswordController@create")->name('forgot.forgot')->middleware('notauth');
Route::post('/forgot',"ForgotPasswordController@store")->name('forgot.postForgot')->middleware('notauth');
Route::get('/resetpassword/{token}',"ForgotPasswordController@edit")->name('forgot.edit')->middleware('notauth')->where('token','[A-Za-z0-9]+');
Route::patch('/resetpassword/{token}',"ForgotPasswordController@update")->name('forgot.update')->middleware('notauth')->where('token','[A-Za-z0-9]+');

//ACTIVATION
Route::get('/activate/{token}',"ActivationController")->name('activate.activate')->where('token','[A-Za-z0-9]+');

//SETTINGS}}
Route::get('/settings',"SettingController@getSetting")->name('setting.setting')->middleware('auth');

Route::post('/settings/emailchange',"EmailChangeController@store")->name('emailchange.store')->middleware('auth');
Route::get('/emailchange/{token}',"EmailChangeController@edit")->where('token','[A-Za-z0-9]+')->name('emailchange.edit')->middleware('auth');

Route::get('/cities','CityController@getCity')->name('city');

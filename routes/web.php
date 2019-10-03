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
Route::get('/login',"LoginController@create")->name("login.create")->middleware('notauth');
Route::post('/login',"LoginController@store")->name("login.store")->middleware('notauth');
Route::get('/logout',"LoginController@destroy")->name('login.destroy')->middleware('auth');

//REGISTER
Route::get('/register',"RegisterController@create")->name("register.create")->middleware('notauth');
Route::post('/register',"RegisterController@store")->name("register.store")->middleware('notauth');

//FORGOT PASSWORD
Route::get('/forgot',"ForgotPasswordController@create")->name('forgot.create')->middleware('notauth');
Route::post('/forgot',"ForgotPasswordController@store")->name('forgot.store')->middleware('notauth');
Route::get('/resetpassword/{token}',"ForgotPasswordController@edit")->name('forgot.edit')->middleware('notauth')->where('token','[A-Za-z0-9]+');
Route::patch('/resetpassword/{token}',"ForgotPasswordController@update")->name('forgot.update')->middleware('notauth')->where('token','[A-Za-z0-9]+');

//ACTIVATION
Route::get('/activate/{token}',"ActivationController")->name('activate.activate')->where('token','[A-Za-z0-9]+');

//SETTINGS
Route::get('/settings',"SettingController@edit")->name('setting.edit')->middleware('auth');

Route::post('/settings/emailchange',"SettingController@test");

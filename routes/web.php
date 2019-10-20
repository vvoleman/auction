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
Route::name('login.')->group(function(){
    Route::get('/login',"LoginController@getLogin")->name("login")->middleware('notauth');
    Route::post('/login',"LoginController@postLogin")->name("postLogin")->middleware('notauth');
    Route::get('/logout',"LoginController@getLogout")->name('logout')->middleware('auth');
});

//REGISTER
Route::name('register.')->middleware('notauth')->prefix('register')->group(function() {
    Route::get('', "RegisterController@getRegister")->name("register");
    Route::post('', "RegisterController@postRegister")->name("postRegister");
});

//FORGOT PASSWORD
Route::name('forgot.')->middleware('notauth')->group(function (){
    Route::get('/forgot',"ForgotPasswordController@create")->name('forgot');
    Route::post('/forgot',"ForgotPasswordController@store")->name('postForgot');
    Route::get('/resetpassword/{token}',"ForgotPasswordController@edit")->name('edit')->where('token','[A-Za-z0-9]+');
    Route::patch('/resetpassword/{token}',"ForgotPasswordController@update")->name('update')->where('token','[A-Za-z0-9]+');
});

//ACTIVATION
Route::get('/activate/{token}',"ActivationController")->name('activate.activate')->where('token','[A-Za-z0-9]+');

//SETTINGS
Route::name('setting.')->prefix("/settings")->middleware('auth')->group(function (){
    Route::get('/',"SettingController@getSetting")->name('setting');
    Route::post('/',"SettingController@postSetting")->name('postSetting');
});

//EMAILCHANGE
Route::name('emailchange.')->middleware('auth')->group(function(){
    Route::post('/settings/emailchange',"EmailChangeController@store")->name('store');
    Route::get('/emailchange/{token}',"EmailChangeController@edit")->where('token','[A-Za-z0-9]+')->name('edit');
});

//AJAX
Route::name('ajax.')->prefix('ajax')->middleware('ajax')->group(function (){
    Route::get('settings/getRegionsByCountry','SettingController@ajaxGetRegionsByCountry')->name("getRegionsByCountry")->middleware('auth');
});

//PROFILEPIC CHANGE
Route::get('/profile/img','ProfileController@getProfileImage')->name('profile.profileimg')->middleware('auth');
Route::post('/profile/imgn','ProfileController@postNewProfileImage')->name('profile.newProfileimg')->middleware('auth');
Route::post('/profile/imgo','ProfileController@postOldProfileImage')->name('profile.oldProfileimg')->middleware('auth');

//PROFILE
Route::get('/profile/{uuid?}','ProfileController@getProfile')->name('profile.profile')->where('uuid','[A-Za-z0-9]+')->middleware('auth');

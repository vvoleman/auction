<?php

use Illuminate\Support\Facades\Log;

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

Route::get('/test','HomeController@getTest');

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
Route::name('setting.')->prefix("/settings")->middleware(['auth','hasPerm:settings.setting'])->group(function (){
    Route::get('/',"SettingController@getSetting")->name('setting');
    Route::post('/',"SettingController@postSetting")->name('postSetting');
});

//EMAILCHANGE
Route::name('emailchange.')->middleware(['auth','hasPerm:settings.email'])->group(function(){
    Route::post('/settings/emailchange',"EmailChangeController@store")->name('store');
    Route::get('/emailchange/{token}',"EmailChangeController@edit")->where('token','[A-Za-z0-9]+')->name('edit');
});

//AJAX
Route::name('ajax.')->prefix('ajax')->middleware('ajax')->group(function (){
    Route::get('/settings/getRegionsByCountry','SettingController@ajaxGetRegionsByCountry')->name("getRegionsByCountry");
    Route::get('/search/getBootInfo','SearchController@ajaxGetBoot')->name('searchBootInfo')->middleware('auth')->middleware(['auth','hasPerm:offers.search']);
    Route::get('/search/getOffers','SearchController@ajaxGetOffers')->name('searchOffers')->middleware('auth')->middleware(['auth','hasPerm:offers.search']);
    Route::post('/notifications/seen','HomeController@ajaxSetNotificationSeen')->name('setNotificationSeen')->middleware('auth');

    Route::post("/imageUpload","ImageUploaderController")->name("imageUpload")->middleware('auth');

    Route::get('/admin/getCategories','CategoryController@ajaxAdminGetCategories')->middleware(['auth','hasPerm:admin.categories']); //TODO: admin pr??va
    Route::post('/admin/newCategory','CategoryController@ajaxAdminCreate')->middleware(['auth','hasPerm:admin.categories']);
    Route::post('/admin/editCategory','CategoryController@ajaxAdminEdit')->middleware(['auth','hasPerm:admin.categories']); //TODO: admin pr??va
    Route::post('/admin/category/uploadFile',"CategoryController@ajaxAdminUploadImage")->middleware(['auth','hasPerm:admin.categories']);

    Route::get('/admin/getPermissions','AdminGroupsController@ajaxGetPermissions')->middleware(['auth','hasPerm:admin.groups']);
    Route::post('/admin/editGroup','AdminGroupsController@ajaxEditGroup')->middleware(['auth','hasPerm:admin.groups']);
    Route::post('/admin/addGroup','AdminGroupsController@ajaxNewGroup')->middleware(['auth','hasPerm:admin.groups']);
    Route::get('/admin/getGroups','AdminGroupsController@ajaxGetGroups')->middleware(['auth','hasPerm:admin.groups']);
    Route::post('/admin/deleteGroup','AdminGroupsController@ajaxDeleteGroup')->middleware(['auth','hasPerm:admin.groups']);
    Route::get('/admin/getGroupHistory','AdminGroupsController@ajaxGetHistory')->middleware(['auth','hasPerm:admin.groups']);

    Route::get('/admin/getBits',"AdminPanelController@ajaxGetBits")->middleware(['auth','hasPerm:admin.dashboard']);
    Route::get('/admin/getByYear',"AdminPanelController@ajaxGetByYear")->middleware(['auth','hasPerm:admin.dashboard']);
    Route::get('/admin/getCategoryPercentage',"AdminPanelController@ajaxGetCategoryPercentage")->middleware(['auth','hasPerm:admin.dashboard']);

    Route::get('/admin/getUsers','AdminUsersController@ajaxGetUsers')->middleware(['auth','hasPerm:admin.users']);
    Route::post('/admin/editUser','AdminUsersController@ajaxEditUser')->middleware(['auth','hasPerm:admin.users']);

    Route::post('/offers/newBuy','OfferController@ajaxBuyOffer')->middleware(['auth','hasPerm:offers.buy']);
    Route::post('/offers/removeOfferSell','OfferController@ajaxRemoveOfferSell')->middleware(['auth','hasPerm:offers.buy']);
    Route::post('/offers/updateImages','OfferController@ajaxUpdateImages')->middleware(['auth','hasPerm:offers.edit']);

    Route::get('/messages/users','MessageController@ajaxGetUsers')->middleware(['auth']);
    Route::get('/messages/contacts','MessageController@ajaxGetContacts')->middleware(['auth']);
    Route::get('/messages/offersells','MessageController@ajaxGetOfferMessagesWith')->middleware(['auth']);
    Route::get('/messages/conversation','MessageController@ajaxGetConversation')->middleware(['auth']);
    Route::post('/messages/markAsSeen','MessageController@ajaxMarkAsSeen')->middleware('auth');
    Route::post('/messages','MessageController@ajaxCreateMessage')->middleware(['auth']);
});

//PROFILEPIC CHANGE
Route::get('/profile/img','ProfileController@getProfileImage')->name('profile.profileimg')->middleware(['auth','hasPerm:profile.pic_change']);
Route::post('/profile/imgn','ProfileController@postNewProfileImage')->name('profile.newProfileimg')->middleware(['auth','hasPerm:profile.pic_change']);
Route::post('/profile/imgo','ProfileController@postOldProfileImage')->name('profile.oldProfileimg')->middleware(['auth','hasPerm:profile.pic_change']);

//PROFILE
Route::get('/profile/{uuid?}','ProfileController@getProfile')->name('profile.profile')->where('uuid','[A-Za-z0-9]+')->middleware(['auth','hasPerm:profile.profile']);

//OFFERS
Route::name('offers.')->group(function (){
    Route::get("/offers/new","OfferController@getNewOffer")->name("new")->middleware(['auth','hasPerm:offers.new']);
    Route::post("/offers/new","OfferController@postNewOffer")->name("postNew")->middleware(['auth','hasPerm:offers.new']);
    Route::get("/offers/{id}/edit","OfferController@getEditOffer")->name("edit")->middleware(['auth','hasPerm:offers.edit'])->where("id","[A-Za-z0-9]+");
    Route::post("/offers/{id}/edit","OfferController@postEditOffer")->name("postEdit")->middleware(['auth','hasPerm:offers.edit'])->where("id","[A-Za-z0-9]+");
    Route::get("/offers/{id}","OfferController@getOffer")->name("offer")->middleware(['auth','hasPerm:offers.offer'])->where("id","[A-Za-z0-9]+");
    Route::post("/offers/{id}/renew","OfferController@postRenew")->name("postRenew")->middleware(['auth','hasPerm:offers.renew'])->where("id","[A-Za-z0-9]+");
    Route::post("/offers/{id}/delete","OfferController@deleteOffer")->name("delete")->middleware(['auth','hasPerm:offers.delete'])->where("id","[A-Za-z0-9]+");
    Route::get("/offers/{id}/sells","OfferSellController@getSells")->name('sells')->middleware(['auth'])->where("id","[A-Za-z0-9]+");
    Route::get("/offers/{id}/sells/{os_id}","OfferSellController@getConfirmOffer")->name('confirm')->middleware(['auth'])->where("id","[A-Za-z0-9]+")->where("os_id","[A-Za-z0-9]+");
    Route::post("/offers/{id}/sells/{os_id}/confirm","OfferSellController@postConfirmOffer")->name('confirm.confirm')->middleware(['auth'])->where("id","[A-Za-z0-9]+")->where("os_id","[A-Za-z0-9]+");
    Route::post("/offers/{id}/sells/{os_id}/deny","OfferSellController@postDenyOffer")->name('confirm.deny')->middleware(['auth'])->where("id","[A-Za-z0-9]+")->where("os_id","[A-Za-z0-9]+");
});

//SEARCH
Route::get("/search","SearchController@getSearch")->name("search.search")->middleware(['auth','hasPerm:offers.search']);

//ADMIN
Route::name("admin.")->prefix("admin")->group(function (){
    Route::get("/","AdminPanelController@getPanel")->middleware(['auth','hasPerm:admin.dashboard'])->name('panel');
    Route::get("/helpdesk","HelpdeskController@getHelpdesk")->middleware(['auth'])->name('helpdek');
    Route::get("/categories","CategoryController@getAdminCategories")->middleware(['auth','hasPerm:admin.categories'])->name("adminCategories");
    Route::get("/groups","AdminGroupsController@getGroups")->middleware(['auth','hasPerm:admin.groups'])->name("groups");
    Route::get("/users","AdminUsersController@getUsers")->middleware(['auth','hasPerm:admin.users'])->name("users");
});


Route::get('/ajax/myoffers','ProfileController@ajaxGetMyOffers');
Route::get('/ajax/myorders','ProfileController@ajaxGetMyOrders');
Route::get('/myoffers','ProfileController@getMyOffers')->name('profile.myOffers')->middleware('auth');
Route::get('/myorders','ProfileController@getMyOrders')->name('profile.myOrders')->middleware('auth');

Route::get('/offersell/{uuid}','OfferSellController@getSell')->name('offersell.offersell')->middleware('auth');
Route::post('/offersell/{uuid}/changeStatus','OfferSellController@ajaxPostChangeStatus')->name('offersell.changeStatus')->middleware('auth');

//MESSAGE
Route::get('/messages','MessageController@getMessage')->name('message.message')->middleware(['auth','hasPerm:chat.chat']);


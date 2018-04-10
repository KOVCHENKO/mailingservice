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

Auth::routes();

Route::group(['middleware' => 'auth'], function() {

    Route::get('/', 'MessageController@show');

    Route::get('/show_messages', 'MessageController@show');
    Route::post('/message/create', 'MessageController@create');
    Route::get('/message/sync/{id}', 'MessageController@sync');

    Route::get('/channel/show_create_view', 'ChannelController@showCreateView' );
    Route::post('/channel/create', 'ChannelController@create' );


    Route::get('/send_again', 'MessageController@attemptToSendAgain');

});
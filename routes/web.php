<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::group(['middleware' => 'auth'], function(){
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  Route::get('/video_chat', 'App\Http\Controllers\VideoChatController@index');
  Route::post('/auth/video_chat', 'App\Http\Controllers\VideoChatController@auth');

    Route::get('/streaming', 'App\Http\Controllers\WebrtcStreamingController@index');
    Route::get('/streaming/{streamId}', 'App\Http\Controllers\WebrtcStreamingController@consumer');
    Route::post('/stream-offer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamOffer');
    Route::post('/stream-answer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamAnswer');

    // Dynamic Presence Channel for Streaming
    Broadcast::channel('streaming-channel.{streamId}', function ($user) {
        return ['id' => $user->id, 'name' => $user->name];
    });

// Signaling Offer and Answer Channels
    Broadcast::channel('stream-signal-channel.{userId}', function ($user, $userId) {
        return (int) $user->id === (int) $userId;
    });
});


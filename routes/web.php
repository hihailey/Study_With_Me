<?php

use Illuminate\Support\Facades\Route;
use App\Models\Group;
use Illuminate\Http\Response;

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

Auth::routes();



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/groups', function () {
        return response()->json([
            'groupsAll' => Group::all()
        ], Response::HTTP_OK);
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/video_chat', 'App\Http\Controllers\VideoChatController@index');
    Route::post('/auth/video_chat', 'App\Http\Controllers\VideoChatController@auth');

    Route::get('/streaming', 'App\Http\Controllers\WebrtcStreamingController@index');
    Route::get('/streaming/{streamId}', 'App\Http\Controllers\WebrtcStreamingController@consumer');
    Route::post('/stream-offer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamOffer');
    Route::post('/stream-answer', 'App\Http\Controllers\WebrtcStreamingController@makeStreamAnswer');

    //chat routes
    Route::get('/chats/{id}/', 'App\Http\Controllers\ChatController@index');
    Route::get('/messages/{id}/', 'App\Http\Controllers\ChatController@fetchAllMessages');
    Route::post('/messages/{id}/', 'App\Http\Controllers\ChatController@sendMessage');
    Route::post('/delete/{code}', 'App\Http\Controllers\ChatController@destroy');
    Route::DELETE('/delete/{id}/', 'App\Http\Controllers\ChatController@delete');

    Route::get('/main', [App\Http\Controllers\MainController::class, 'index'])->name('main');
    // Route::get('/main', function () {
    //     return view('main');
    // });
    Route::get('/group/create', 'App\Http\Controllers\GroupController@create_form');
    Route::post('/group/create', 'App\Http\Controllers\GroupController@create');
    Route::get('/group/join', 'App\Http\Controllers\GroupController@join_form');
    Route::post('/group/join', 'App\Http\Controllers\GroupController@join');

    Route::get('/subscribe', 'App\Http\Controllers\ChatController@subscribe');

    // Dynamic Presence Channel for Streaming
    Broadcast::channel('streaming-channel.{streamId}', function ($user) {
        return ['id' => $user->id, 'name' => $user->name];
    });

    // Signaling Offer and Answer Channels
    Broadcast::channel('stream-signal-channel.{userId}', function ($user, $userId) {
        return (int) $user->id === (int) $userId;
    });
});

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

Route::get('/', 'TopicsController@index')->name('home');

Route::get('/chat/room/{room}', 'ChatController@room')->name('chat.room');
Route::post('/chat/init', 'ChatController@init')->name('chat.init');
Route::post('/chat/say', 'ChatController@say')->name('chat.say');

Auth::routes(['verify' => true]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::resource('topics', 'TopicsController', [
    'only' => [
        'create', 'store', 'update', 'edit', 'destroy'
    ]
]);

Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::resource('users', 'UsersController', [
    'only' => [
        'show', 'update', 'edit'
    ]
]);

Route::resource('categories', 'CategoriesController', [
    'only' => ['show']
]);

Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);
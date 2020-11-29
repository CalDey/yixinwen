<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/','PagesController@root')->name('root');
Route::get('/','ArticlesController@recommend')->name('root')->middleware('verified');

Auth::routes(['verify' => true ]);

// Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

Route::resource('articles', 'ArticlesController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::get('articles/{article}/{slug?}', 'ArticlesController@show')->name('articles.show');

Route::resource('categories', 'CategoriesController',['only'=>['show']]);

Route::post('upload_image', 'ArticlesController@uploadImage')->name('articles.upload_image');

Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

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
})->name('home');



Route::auth();


// Statuses
//Route::resource('statuses','StatusesController')->middleware('auth',['except' => ['index']]);
Route::post('statuses','StatusesController@store')->name('statuses.store')->middleware('auth');
Route::get('statuses','StatusesController@index')->name('statuses.index');

//Like Status
Route::post('statuses/{status}/likes', 'StatusLikesController@store')->name('statuses.likes.store')->middleware('auth');
Route::delete('statuses/{status}/likes', 'StatusLikesController@destroy')->name('statuses.likes.destroy')->middleware('auth');

//Comments
Route::post('statuses/{status}/comments', 'StatusesCommentsController@store')->name('statuses.comments.store')->middleware('auth');
Route::post('comments/{comment}/likes', 'CommentsLikesController@store')->name('comments.likes.store')->middleware('auth');
Route::delete('comments/{comment}/likes', 'CommentsLikesController@destroy')->name('comments.likes.destroy')->middleware('auth');

//Users
Route::get('{user}','UserController@show')->name('users.show');

//Route::get('/prueba', function () {
////    $valor = route('statuses.store',['body' => 'Mi primer status']);
//    dd(auth()->id());
//});
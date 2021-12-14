<?php
use Gondr\App\Route;

Route::get('/', "MainController@index");

Route::get('/login', "MainController@login");
Route::post('/login', "MainController@loginProcess");


Route::get('/join', "MainController@join");
Route::post('/join', "MainController@joinProcess");

Route::get('/look', "MainController@look");

Route::get('/wrtie', "MainController@wrtie");
Route::post('/wrtie', "MainController@wrtieProcess");

Route::get('/list', "MainController@list");
// Route::post('/list ', "MainController@downloadProcess");




Route::get('/admin', "MainController@admin");
Route::post('/admin', "MainController@releProcess");

Route::get('/fundthis', "MainController@roleProcess");


Route::get('/profil', "MainController@profil");
Route::get('/inv', "MainController@inv");

Route::post('/popup', "MainController@popupProcess");
Route::post('/end', "MainController@endProcess");
Route::get('/logout', "MainController@logout");

<?php

use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;

// use Illuminate\Routing\Route;

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

// use Illuminate\Support\Facades\Request;

Route::get('/user', 'RefferalController@reffInit')->name('user.reff');
Route::post('/userGenerateRefID', 'RefferalController@generateRefId')->name('reff.generate');

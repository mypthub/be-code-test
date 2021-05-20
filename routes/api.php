<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthController@authenticate');

/** When user tries to access the authorised endpoints without passing access token then return below response */
Route::get('login', 'AuthController@login')->name('login');

Route::group(['prefix' => 'organisation', 'middleware' => ['auth:api']], function() {
	Route::get('/{filter?}', 'OrganisationController@listAll');
    Route::post('', 'OrganisationController@store');
});

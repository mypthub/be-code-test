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

Route::prefix('organisation')->group(function () {
    Route::get('list', 'OrganisationController@listAll');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'organisation','middleware' => ['auth:api']],function(){
    Route::post('create', 'OrganisationController@store');
});

Route::middleware('auth:api')->group( function () {
    Route::post('logout', 'AuthController@logout');
});

/* Route::prefix('organisation')->group(function () {
    Route::get('list', 'OrganisationController@listAll');
    Route::post('', 'OrganisationControlller@create');
}); */





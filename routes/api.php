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

Route::post('login', 'AuthController@authenticate')
    ->name('api.login');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('api.user.me');

    Route::prefix('organisation')->group(function () {
        Route::get('', 'OrganisationController@listAll')
            ->name('api.organisation.list');
        Route::post('', 'OrganisationController@store')
            ->name('api.organisation.create');
    });
});


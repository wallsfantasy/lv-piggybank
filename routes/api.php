<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();

//Route::post('/user/register', 'App\Module\User\Application\RegisterUserHttp@RegisterUser')
//    ->middleware('auth:api');

Route::group(['namespace' => 'User'], function () {
    Route::post('/user/register', 'RegisterUserController')
        ->name('user.register');
});

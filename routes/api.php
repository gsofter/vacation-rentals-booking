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

Route::post('/login', 'Api\Auth\LoginController@Login')->name('api.login');
//contact us
Route::post('/getMail', function(){
    return "Hello";
});//'Api\PostController@save'
//Other in list your home
Route::get('/getOther', 'Api\PostController@getother');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




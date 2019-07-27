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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



//route api register
Route::post('/user_Reg', 'ApiController@register');
//rout to get all user
Route::get('/all_user', 'ApiController@alluser');
//rount to get user
Route::post('/login', 'ApiController@login');
//rount to delete user
Route::post('/delete_user', 'ApiController@deleteuser');

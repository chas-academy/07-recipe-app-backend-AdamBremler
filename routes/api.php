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

Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');
 
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'ApiController@logout');
 
    Route::get('user', 'ApiController@getAuthUser');
 
    Route::get('lists', 'RecipeListController@index');
    Route::get('lists/{id}', 'RecipeListController@show');
    Route::post('lists', 'RecipeListController@store');
    Route::put('lists/{id}', 'RecipeListController@update');
    Route::delete('lists/{id}', 'RecipeListController@destroy');
});

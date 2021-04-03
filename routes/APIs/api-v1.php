<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::get('me', 'AuthController@me')->middleware('auth');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('logout', 'AuthController@logout')->middleware('auth');
});

Route::group(['prefix' => 'users'], function () {
    Route::post('', 'UserController@store');
});

Route::group(['prefix' => 'contacts', 'middleware' => ['auth']], function () {
    Route::get('', 'ContactController@index');
    Route::post('', 'ContactController@store');
    Route::get('{contactId}', 'ContactController@show');
    Route::put('{contact}', 'ContactController@update');
    Route::delete('{contact}', 'ContactController@delete');
});

Route::group(['prefix' => 'companies', 'middleware' => ['auth']], function () {
    Route::get('', 'CompanyController@index');
    Route::post('', 'CompanyController@store');
    Route::get('{companyId}', 'CompanyController@show');
});

Route::group(['prefix' => 'contact-permissions', 'middleware' => ['auth']], function () {
    Route::get('', 'ContactPermission@modes');
});

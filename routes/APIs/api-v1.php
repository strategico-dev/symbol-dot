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
    Route::put('{company}', 'CompanyController@update');
    Route::delete('{company}', 'CompanyController@delete');

    Route::group(['prefix' => '{company}/employees'], function () {
        Route::get('', 'EmployeeController@index');
        Route::post('', 'EmployeeController@store');
        Route::delete('{employee}', 'EmployeeController@delete');
    });
});

Route::group(['prefix' => 'contact-permissions', 'middleware' => ['auth']], function () {
    Route::get('', 'ContactPermission@modes');
});

Route::group(['prefix' => 'sales-funnels'], function () {
    Route::get('', 'SalesFunnelController@index');
    Route::post('', 'SalesFunnelController@store');
    Route::get('{salesFunnelId}', 'SalesFunnelController@show');
    Route::delete('{salesFunnel}', 'SalesFunnelController@delete');

    Route::group(['prefix' => '{salesFunnel}/sales-stages'], function () {
        Route::get('', 'SalesStageController@index');
        Route::post('', 'SalesStageController@store');
        Route::put('swapper', 'SalesStageController@swap');
        Route::delete('{salesStage}', 'SalesStageController@delete');
    });

    Route::group(['prefix' => '{salesFunnel}/contacts/{contact}', 'middleware' => ['can:update,salesFunnel', 'can:update,contact']], function () {
        Route::post('', 'ContactFunnelController@add');
        Route::put('mover', 'ContactFunnelController@move');
        Route::delete('', 'ContactFunnelController@delete');
    });
});

Route::group(['prefix' => 'searcher'], function () {
    Route::get('contacts', 'SearchController@contacts');
});

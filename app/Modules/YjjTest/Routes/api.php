<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/YjjTest', function (Request $request) {
    // return $request->YjjTest();
})->middleware('auth:api');

Route::any('/date/demo1', ['uses' => 'DateController@demo1']);
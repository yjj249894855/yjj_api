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


$api = app("Dingo\Api\Routing\Router");
$api->version("v1",function ($api) {
    $api->post("login", "App\Http\Controllers\API\PassportController@login");
    $api->post("register", "App\Http\Controllers\API\PassportController@register");
    $api->group(["middleware" => "auth:api"], function($api){
        $api->post("details", "App\Http\Controllers\API\PassportController@getDetails");
    });
});
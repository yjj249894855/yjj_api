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

Route::get('/UserAdmin', function (Request $request) {
    // return $request->UserAdmin();
})->middleware('auth:api');

$api = app("Dingo\Api\Routing\Router");
$api->version("v1", function ($api) {
    $api->post("user/login", "App\Modules\UserAdmin\Http\Controllers\UserController@login");
    $api->group(["middleware" => "auth:api"], function ($api) {
        $api->get("user/email/{email}", "App\Modules\UserAdmin\Http\Controllers\UserController@getUserByEmail");
        $api->post("user/show", "App\Modules\UserAdmin\Http\Controllers\UserController@show");
        $api->post("user/menu", "App\Modules\UserAdmin\Http\Controllers\UserController@menu");
        $api->post("user/ceshi", "App\Modules\UserAdmin\Http\Controllers\UserController@ceshi");
    });
});
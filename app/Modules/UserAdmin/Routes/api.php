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

//Route::get('/UserAdmin', function (Request $request) {
//    // return $request->UserAdmin();
//})->middleware('auth:api');

$api = app("Dingo\Api\Routing\Router");
$api->version("v1", function ($api) {
    $api->post("main/login", "App\Modules\UserAdmin\Http\Controllers\MainController@login");
    $api->post("main/logout", "App\Modules\UserAdmin\Http\Controllers\MainController@logout");
    $api->post("main/upload", "App\Modules\UserAdmin\Http\Controllers\BaseController@upload");
    $api->group(["middleware" => "auth:api"], function ($api) {
        $api->get("base/user-info", "App\Modules\UserAdmin\Http\Controllers\BaseController@userInfo");
        $api->get("base/menu", "App\Modules\UserAdmin\Http\Controllers\BaseController@menu");

//        $api->get("user/email/{email}", "App\Modules\UserAdmin\Http\Controllers\UserController@getUserByEmail");
//        $api->post("user/ceshi", "App\Modules\UserAdmin\Http\Controllers\UserController@ceshi");
        $api->resource('user', 'App\Modules\UserAdmin\Http\Controllers\UserController',['parameters' => [
            'user' => 'id'
        ]]);
    });
});
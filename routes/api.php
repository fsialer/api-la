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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
}*/
$api=app('Dingo\Api\Routing\Router');
$api->version('v1',function($api){
    $api->group(['middleware'=>'cors'],function($api){
        $api->post('login','App\Http\Controllers\AuthenticationController@login');
        $api->post('signup','App\Http\Controllers\AuthenticationController@signup');
        $api->resource('users','App\Http\Controllers\UserController');
        $api->get('users/paginated/{page}','App\Http\Controllers\UserController@paginated')->name("users.paginated");
    });
});

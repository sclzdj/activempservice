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
}
);


$api = app(\Dingo\Api\Routing\Router::class);
#默认指定的是v1版本和前缀方式，则直接通过 {host}/{前缀}/{接口名} 访问即可
#namespace为API控制器公共命名空间
$api->version('v1', ['namespace' => '\App\Http\Controllers\Api'], function ($api) {
    #api.throttle中间件是限制请求次数 每expires分钟只能请求limit次
    $api->group(['middleware' => 'api.throttle', 'limit' => 1000, 'expires' => 1], function ($api) {
        $api->any('upload', 'UploadController@main');
        $api->get('login', 'UserController@mpLogin');
        $api->post('login', 'UserController@login');
        $api->get('me', 'UserController@me');
        $api->get('event/getHomeData', 'EventController@getHomeData');
        $api->get('event/getPageData', 'EventController@getPageData');
        $api->get('event/getOne', 'EventController@getOne');
        $api->get('slide/getData', 'SlideController@getData');
        $api->put('user/save', 'UserController@save');
    }
    );
}
);
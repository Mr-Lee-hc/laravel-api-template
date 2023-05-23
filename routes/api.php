<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'App\Http\Controllers'
], function ($r) {

    $r->post('login', 'AuthorizationController@login');
    $r->group(['middleware' => 'auth:api'],function($r){
        // 退出
        $r->delete('logout', 'AuthorizationController@logout');
    });

    // web
    $r->group([
        'namespace' => 'Web',
        'prefix' => 'web',
    ],function($r){
        // 登录
        $r->post('login', 'AuthorizationController@login');

        $r->group(['middleware' => 'auth:suppliers'],function($r){

        });
    });
});

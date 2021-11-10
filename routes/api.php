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
});*/


Route::group(['prefix' => 'logs'], function () {
    Route::any("o", "Api\EmailLogController@open")->name("emailLog.open");
    Route::any("o_l", "Api\EmailLogController@openLink")->name("emailLog.open.link");
    Route::post("o_p", "Api\EmailLogController@postLog")->name("api.email_logs.post.log");
    Route::any("o_a", "Api\EmailLogController@openAttachment")->name("emailLog.open.attachment");
});

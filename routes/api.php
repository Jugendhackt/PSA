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

//Controller aufrufen mit $all = true;
Route::get('twitter/counter_all/{userhandle}', "UserTimelineController@countHashtags")->defaults('all','true');
Route::get('twitter/timeline/{userhandle}/{amount}', "UserTimelineController@dumpTimeline");
Route::get('twitter/timeline_all/{userhandle}',"UserTimelineController@getAllTweets");

Route::get('twitter/counter/{userhandle}',"UserTimelineController@countHashtags");
Route::get('twitter/random/{userhandle}',"UserTimelineController@randomTweet");

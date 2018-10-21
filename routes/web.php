<?php
use App\Http\Controllers\UserTimelineController;
//use App\Http\Middleware\CorsMiddleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('start');
});
Route::get('statistics', function () {
    return view('statistics');
});
Route::get('game', function () {
    return view('game');
});
Route::get('comparison', function () {
    return view('comparison');
});

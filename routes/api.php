<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Facade\FlareClient\Api;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});


Route::middleware(['jwt.verify'])->group(function(){

Route::get('/posts', 'Api\PostController@index');
Route::post('/posts', 'Api\PostController@store');
Route::get('/posts/{id}', 'Api\PostController@show');
Route::post('/posts/{id}', 'Api\PostController@update');
Route::post('/posts_delete/{id}', 'Api\PostController@destroy');

});


/*Route::get('/posts', 'Api\PostController@index')->middleware('auth:api');
Route::post('/posts', 'Api\PostController@store');
Route::get('/posts/{id}', 'Api\PostController@show');
Route::post('/posts/{id}', 'Api\PostController@update');
Route::post('/posts_delete/{id}', 'Api\PostController@destroy');*/


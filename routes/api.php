<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ErrorController;

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

//get
// Route::get('admins', 'AdminController@index');
Route::get('admins', [AdminController::class, 'index']);

// Route::get('admins/{id}','AdminController@show');
Route::get('admin/{username}', [AdminController::class, 'show']);

// Route::post('admin', 'AdminController@store');
Route::post('admin', [AdminController::class, 'store']);

Route::put('admin', [AdminController::class, 'store']);

// Route::put('admins', 'AdminController@store');

// Route::delete('admins', 'AdminController@destroy');
Route::delete('admin/{username}', [AdminController::class, 'destroy']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('errors', [ErrorController::class, 'index']);

Route::get('errors/{id}', [ErrorController::class, 'show']);

Route::post('errors', [ErrorController::class, 'store']);

Route::put('errors', [ErrorController::class, 'store']);

Route::delete('errors', [ErrorController::class, 'destroy']);
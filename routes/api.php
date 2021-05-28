<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\CobLogController;
use App\Http\Controllers\SystemController;

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

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
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

// Route::post('login/{finUsername}&{finPassword}', [AdminController::class, 'corporateLogin']);
Route::post('login/', [AdminController::class, 'corporateLogin']);

Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);


//Errors and Resolutions API Routes
Route::get('errors', [ErrorController::class, 'index']);
Route::get('errors/unselected/{id}', [ErrorController::class, 'unselectedErrors']);
Route::get('error/{id}', [ErrorController::class, 'show']);
Route::post('error', [ErrorController::class, 'store']);
Route::put('error', [ErrorController::class, 'store']);
Route::delete('error/{id}', [ErrorController::class, 'destroy']);


//Cob Logs API Routes
Route::get('coblogs', [CobLogController::class, 'index']);
Route::get('coblog/{id}', [CobLogController::class, 'show']);
Route::get('coblog/{id}/errors', [CobLogController::class, 'showErrors']);
Route::post('coblogError', [CobLogController::class, 'storeCoblogError']);
Route::post('coblog', [CobLogController::class, 'store']);
Route::put('coblog', [CobLogController::class, 'store']);
Route::delete('coblog/{log_id}/{error_id}', [CobLogController::class, 'destroy']);


//Systems API Routes
Route::get('systems', [SystemController::class, 'index']);
Route::get('system/{id}', [SystemController::class, 'show']);
Route::post('system', [SystemController::class, 'store']);
Route::put('system', [SystemController::class, 'store']);
Route::delete('system/{id}', [SystemController::class, 'destroy']);

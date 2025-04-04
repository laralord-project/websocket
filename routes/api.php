<?php

use App\Http\Controllers\v1\SystemController;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\UserController;
use App\Http\Controllers\WebsocketAppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix('api')->middleware(["json", 'auth:sanctum'])->group(function ($route){
    $route->apiResource('applications', WebsocketAppController::class);
} );



<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GraphController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user', [AuthController::class, 'get_user']);
Route::get('/test_dijkstra', [AuthController::class, 'test_dijkstra']);

Route::get('/shortest-path/{start}/{end}', [GraphController::class, 'shortestPath']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

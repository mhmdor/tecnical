<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
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

Route::post('register', [UserController::class, 'register']);

Route::post('login', [UserController::class, 'login']);

Route::get('getUser', [UserController::class, 'index']);

Route::get('activeUsers', [UserController::class, 'activeUsers']);

Route::get('getCategories', [CategoryController::class, 'index']);

Route::get('activityUser/{id}', [UserController::class, 'active']);





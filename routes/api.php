<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\CityController;

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

// Route::controller(RegisterController::class)->group(function(){
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('login', [RegisterController::class,'login']);
    Route::post('forgot_password', [RegisterController::class,'forgot_password']);
    Route::post('reset_password', [RegisterController::class,'reset']);
    Route::post('contact', [RegisterController::class,'contact']);
// });
        
// Route::middleware('auth:sanctum')->group( function () {
    Route::post('logout',[RegisterController::class, 'logout']);
    Route::match(['GET','POST'],'addCity',[CityController::class, 'addCity']);
    Route::match(['GET','POST'],'addPlace',[CityController::class, 'addPlace']);
    Route::match(['GET','POST'],'addGuider',[CityController::class, 'addGuider']);
    Route::match(['GET','POST'],'updateGuider',[CityController::class, 'updateGuider']);
    Route::match(['GET','POST'],'updatePlace',[CityController::class, 'updatePlace']);
    Route::match(['GET','POST'],'updateCity',[CityController::class, 'updateCity']);
    Route::post('deleteData',[CityController::class, 'deleteData']);
// });

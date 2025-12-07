<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorNodeController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user/display', [UserController::class , 'displayUser']);


Route::post('/share/store', [ShareController::class , 'storeShareAccess']);


Route::get('/diagrams/display', [DiagramController::class , 'displayDiagrams']);
Route::get('/diagrams/display/{id}', [DiagramController::class , 'displayDiagramsbyID']);
Route::post('/diagrams/store', [DiagramController::class , 'storeDiagrams']);
Route::put('/diagrams/update/{id}', [DiagramController::class , 'updateDiagrams']);
Route::put('/diagrams/updateShareable/{id}', [DiagramController::class , 'updateShareable']);
Route::get('/diagrams/user/{id}', [DiagramController::class, 'displayUserDiagrams']);

Route::get('/color/display', [ColorNodeController::class , 'displayDiagramsColorNode']);
Route::post('/color/store', [ColorNodeController::class , 'storeDiagramsColorNode']);

Route::post('/google-login', [AuthController::class, 'googleLogin']);


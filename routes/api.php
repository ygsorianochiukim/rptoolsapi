<?php

use App\Http\Controllers\ColorNodeController;
use App\Http\Controllers\DiagramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/diagrams/display', [DiagramController::class , 'displayDiagrams']);
Route::get('/diagrams/display/{id}', [DiagramController::class , 'displayDiagramsbyID']);
Route::post('/diagrams/store', [DiagramController::class , 'storeDiagrams']);
Route::put('/diagrams/update/{id}', [DiagramController::class , 'updateDiagrams']);

Route::get('/color/display', [ColorNodeController::class , 'displayDiagramsColorNode']);
Route::post('/color/store', [ColorNodeController::class , 'storeDiagramsColorNode']);

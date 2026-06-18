<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUploadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// VPS File Storage Prototype Endpoints
Route::post('/upload', [FileUploadController::class, 'upload']);
Route::post('/delete', [FileUploadController::class, 'delete']);

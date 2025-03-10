<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ClassesController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Route::post('register', [AuthController::class,'register'])->name('register');
Route::post('login', [AuthController::class,'login'])->name("login");

Route::middleware('auth:api')->group(function () {
    Route::apiResource("teachers", TeacherController::class);
});
Route::middleware('auth:api')->group(function () {
    Route::apiResource("students", StudentController::class);
});
Route::middleware('auth:api')->group(function () {
    Route::apiResource("classes", ClassesController::class);
});
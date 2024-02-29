<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JobTitleController;
use App\Models\department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::post("login",[AuthController::class,"login"]);
Route::post("register",[AuthController::class,"registerNewEmployee"]);


Route::middleware('auth:sanctum')->group(function () {

    Route::post("/user/add",[AuthController::class,"addUser"]);
    Route::put('/user/{id}', [AuthController::class, 'updateUser']);
    Route::delete('/user/{id}', [AuthController::class, 'deleteUser']);
    Route::get('/user/{id}', [AuthController::class, 'showUser']);
    Route::get('/users', [AuthController::class, 'listUsers']);
   
  
});

Route::get('/departments', [DepartmentController::class, 'index']);
Route::post("/departments/add",[DepartmentController::class,"store"]);
Route::delete('/departments/{id}', [DepartmentController::class, 'delete']);



Route::get('/job_titles', [JobTitleController::class, 'index']);
Route::post("/job_titles/add",[JobTitleController::class,"store"]);


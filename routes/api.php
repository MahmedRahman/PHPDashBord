<?php
use App\Http\Controllers\userController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ExcuseController;
use App\Http\Controllers\JobTitleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\vacationController;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;


Route::post("login", [AuthController::class, "login"]);
Route::post("register", [AuthController::class, "registerNewEmployee"]);
Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/job_titles', [JobTitleController::class, 'index']);
Route::get('/users', [userController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    
  
    Route::post("/user/add", [userController::class, "store"]);
    Route::delete('/user/{id}', [userController::class, 'delete']);
    Route::put('/user/{id}', [userController::class, 'update']);


    
    Route::post("/departments/add", [DepartmentController::class, "store"]);
    Route::delete('/departments/{id}', [DepartmentController::class, 'delete']);

   
    Route::post("/job_titles/add", [JobTitleController::class, "store"]);
    Route::delete('/job_titles/{id}', [JobTitleController::class, 'delete']);

    Route::get('/vacation', [vacationController::class, 'index']);
    Route::post("/vacation/add", [vacationController::class, "store"]);
    Route::delete('/vacation/{id}', [vacationController::class, 'delete']);
    Route::put('/vacation/{id}', [vacationController::class, 'update']);

    
   
    Route::get('/excuses', [ExcuseController::class, 'index']);
    Route::get('/excuses/{id}', [ExcuseController::class, 'show']);
    Route::post('/excuses/add', [ExcuseController::class, 'store']);
    Route::put('/excuses/{id}', [ExcuseController::class, 'update']);
    Route::delete('/excuses/{id}', [ExcuseController::class, 'delete']);


    Route::get('/settings', [SettingController::class, 'index']);
    Route::post('/settings', [SettingController::class, 'setSetting']);
    Route::get('/settings/{key}', [SettingController::class, 'getSetting']);

});


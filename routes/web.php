<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class,'index']);
Route::get('/users/create', [UserController::class,'create']);
Route::post('/users', [UserController::class,'store']);

Route::middleware("IfLogin")->group(function () {
// Login
Route::get("/auth/login",[AuthenticateController::class,"login"])->name("login");
Route::post("/auth/login",[AuthenticateController::class,"loginAction"])->name("loginAction");
});

Route::middleware("ValidationUser")->group(function () {
    
    Route::middleware("Role:admin")->group(function () {
    Route::get("/admin/dashboard",[AdminController::class,"dashboard"])->name("admin.dashboard");
    });

    Route::middleware("Role:employee")->group(function () {
    Route::get("/employee/dashboard",[EmployeeController::class,"dashboard"])->name("employee.dashboard");
    Route::get("/employee/change-profile",[AuthenticateController::class,"formChangeProfile"])->name("");
    Route::put("/employee/update/change-profile",[AuthenticateController::class,"changeProfile"])->name("");
    Route::put("/employee/update/change-password",[AuthenticateController::class,"changePassword"])->name("");

    //drugs
    Route::get("/employee/drugs/stock-list",[EmployeeController::class,"listdrugs"])->name("");
    Route::get("/employee/drugs/stock-list/{id}/batch-drugs",[EmployeeController::class,"listBatchDrugs"])->name("");
    Route::delete("/employee/drugs/stock-list/{id}/batch-drugs/{idBatch}",[EmployeeController::class,"deleteBatchDrugs"])->name("");
    });

    Route::middleware("Role:manager")->group(function () {
    Route::get("/manager/dashboard",[ManagerController::class,"dashboard"])->name("manager.dashboard");
    });


    Route::delete("/auth/logout",[AuthenticateController::class,"logout"])->name("logout");
});
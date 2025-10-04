<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\UserController;
use App\Notifications\ExampleNotification;
use App\Services\MedicineMasterService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/auth/login');
});

// Route::get('/manager/users', [UserController::class,'index']);
// Route::get('/manager/users/create', [UserController::class,'create']);
// Route::post('/manager/users', [UserController::class,'store']);

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
    Route::get("/employee/drugs/expired",[EmployeeController::class,"expiredBatchDrugs"])->name("");
    Route::delete("/employee/drugs/expired/{id}",[EmployeeController::class,"deleteExpiredBatchDrugs"])->name("");
    Route::delete("/employee/drugs/expired/",[EmployeeController::class,"deleteAllExpiredBatchDrugs"])->name("");

    //transaction
    Route::get("/employee/transaction-outgoing/",[EmployeeController::class,"transactionOutgoing"])->name("");
    Route::post("/employee/transaction-outgoing/",[EmployeeController::class,"transactionOutgoingAction"])->name("");
    Route::get("/employee/transaction-outgoing/{id}",[EmployeeController::class,"transactionOutgoingForm"])->name("");
    Route::get("/employee/transaction-outgoing/{id}/add-item",[EmployeeController::class, "transactionOutgoingAddItem"])->name("");
    Route::post("/employee/transaction-outgoing/{id}/add-item",[EmployeeController::class, "transactionOutgoingAddActionItem"])->name("");
    Route::delete("/employee/transaction-outgoing/{id}/item/{idItem}",[EmployeeController::class, "transactionOutgoingDeleteActionItem"])->name("");
    Route::put("/employee/transaction-outgoing/{id}",[EmployeeController::class, "transactionOutgoingUpdateAction"])->name("");

    //history transaction
    Route::get("/employee/history-transaction-outgoing/",[EmployeeController::class,"historyTransactionOutgoing"])->name("");
    Route::delete("/employee/history-transaction-outgoing/{id}",[EmployeeController::class,"deleteTransactionOutgoing"])->name("");

    //Generate PDF
    Route::post("/employee/history-transaction-outgoing/",[PDFController::class,"generateAllTransactionOutgoing"])->name("");
    Route::post("/employee/get-one-transaction-outgoing/",[PDFController::class,"generateOneTransactionOutgoing"])->name("");
});

    Route::middleware("Role:manager")->group(function () {
    Route::get("/manager/dashboard",[ManagerController::class,"dashboard"])->name("manager.dashboard");
    // Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    // Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/manager/users', [UserController::class,'index']);
    Route::get('/manager/users/create', [UserController::class,'create']);
    Route ::get('/manager/users/{id}/create', [UserController::class,'edit'])->name('users.update');
    Route::put('/manager/users/{id}', [UserController::class, 'update']);
    Route::post('/manager/users', [UserController::class,'store']);
    Route::delete('/manager/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/manager/users/{id}/sendPasswordEmail', [UserController::class, 'sendPasswordEmail'])->name('users.sendPasswordEmail');
    Route::get("/manager/change-profile",[AuthenticateController::class,"formChangeProfile"])->name("");
    Route::put('/manager/update/change-profile', [AuthenticateController::class, 'ChangeProfile'])->name('manager.changeProfile');
    Route::put('/manager/update/change-password', [AuthenticateController::class, 'changePassword'])->name('');
    Route::get('/manager/history', [ManagerController::class, 'historyTransaction'])->name('');
    Route::post('/manager/history',[PDFController::class,'generateAllTransactionOutgoing'])->name("");
    Route::post('/manager/get-one-history/',[PDFController::class,'generateOneTransactionOutgoing'])->name('');
    Route::delete('/manager/history/{id}', [ManagerController::class, 'DeleteHistoryTransaction'])->name('');
    Route::get('/manager/DrugList', [ManagerController::class, 'DrugList'])->name('');
    Route::get('/manager/DrugExpired', [ManagerController::class, 'ExpiredDrug'])->name('');
    Route::delete('/manager/DrugExpired/{id}', [ManagerController::class, 'DeleteExpiredDrug'])->name('');
});



    Route::delete("/auth/logout",[AuthenticateController::class,"logout"])->name("logout");
});


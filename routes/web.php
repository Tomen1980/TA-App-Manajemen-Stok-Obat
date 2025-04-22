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


Route::get('/users', [UserController::class,'index']);
Route::get('/users/create', [UserController::class,'create']);
Route::post('/users', [UserController::class,'store']);

Route::middleware("IfLogin")->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
// Login
Route::get("/auth/login",[AuthenticateController::class,"login"])->name("login");
Route::post("/auth/login",[AuthenticateController::class,"loginAction"])->name("loginAction");
});

Route::middleware("ValidationUser")->group(function () {
    
    Route::middleware("Role:admin")->group(function () {
        Route::get("/admin/dashboard",[AdminController::class,"dashboard"])->name("admin.dashboard");
        Route::get("/admin/change-profile",[AuthenticateController::class,"formChangeProfile"])->name("");
        Route::put("/admin/update/change-profile",[AuthenticateController::class,"changeProfile"])->name("");
        Route::put("/admin/update/change-password",[AuthenticateController::class,"changePassword"])->name("");

        Route::get("/admin/drugs/typed",[AdminController::class,"typedDrugs"])->name("admin.typedDrugs");
        Route::get("/admin/drugs/from-typed-drugs",[AdminController::class,"formDrugs"])->name("admin.formDrugs");
        Route::post("/admin/drugs/from-typed-drugs",[AdminController::class,"drugsActionStored"])->name("admin.DrugsActionStored");
        Route::get("/admin/drugs/from-typed-drugs/{id}",[AdminController::class,"formDrugs"]);
        Route::get("/admin/drugs/from-typed-drugs/{id}/batch",[AdminController::class,"batchDrugs"]);
        Route::get("/admin/drugs/from-typed-drugs/{id}/form-batch-drugs",[AdminController::class,"formBatchDrugs"]);
        Route::post("/admin/drugs/from-typed-drugs/{id}/form-batch-drugs",[AdminController::class,"batchDrugsActionStored"]);
        Route::put("/admin/drugs/from-typed-drugs/{id}",[AdminController::class,"drugsActionUpdate"])->name("admin.DrugsActionUpdate");
        Route::delete("/admin/drugs/typed/{id}",[AdminController::class,"drugsActionDelete"])->name("admin.DrugsActionDelete");
    
        //categories
        Route::get("/admin/category/list-category",[AdminController::class,"listCategory"])->name("");
        Route::get("/admin/category/formCategory",[AdminController::class,"formCategory"])->name("");
        Route::post("/admin/category/formCategory",[AdminController::class,"categoryActionStored"])->name("");
        Route::delete("/admin/category/list-category/{id}",[AdminController::class,"categoryActionDelete"])->name("");
        Route::get("/admin/category/formCategory/{id}",[AdminController::class,"formCategory"])->name("");
        Route::put("/admin/category/formCategory/{id}",[AdminController::class,"categoryActionUpdate"])->name("");
        Route::post("/admin/category/formCategory/{id}",[AdminController::class,"categoryActionStored"])->name("");
       
        Route::get("/admin/suppliers/list-supplier",[AdminController::class,"listSuppliers"])->name("");
        Route::get("/admin/suppliers/form-supplier",[AdminController::class,"formSuppliers"])->name("");
        Route::post("/admin/suppliers/form-supplier",[AdminController::class,"suppliersActionStored"])->name("");
        Route::delete("/admin/suppliers/list-supplier/{id}",[AdminController::class,"suppliersActionDelete"])->name("");
        Route::get("/admin/suppliers/form-supplier/{id}",[AdminController::class,"formSuppliers"])->name("");
        Route::put("/admin/suppliers/form-supplier/{id}",[AdminController::class,"suppliersActionUpdate"])->name("");

        Route::get("/admin/user/list-user",[AdminController::class,"listUser"])->name("");
        Route::get("/admin/user/form-user",[AdminController::class,"formUser"])->name("");
        Route::post("/admin/user/form-user",[AdminController::class,"userActionStored"])->name("");
        Route::delete("/admin/user/list-user/{id}",[AdminController::class,"userActionDelete"])->name("");
        Route::get("/admin/user/form-user/{id}",[AdminController::class,"formUser"])->name("");
        Route::put("/admin/user/form-user/{id}",[AdminController::class,"userActionUpdate"])->name("");
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
    });


    Route::delete("/auth/logout",[AuthenticateController::class,"logout"])->name("logout");
});


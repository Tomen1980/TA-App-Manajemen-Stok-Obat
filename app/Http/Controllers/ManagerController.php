<?php

namespace App\Http\Controllers;
use App\Services\AuthenticateService;
use Illuminate\Http\Request;
use App\Services\MedicineMasterService;
use App\Services\CategoryService;
use App\Services\BatchDrugsService;
use App\Services\TransactionService;
use App\Services\TransactionItemService;

class ManagerController extends Controller
{
    protected $medicineService;
    protected $CategoryService;
    protected $batchDrugsService;
    protected $transactionService;
    protected $transactionItemService;
    public function __construct(MedicineMasterService $medicineService, CategoryService $CategoryService, BatchDrugsService $batchDrugsService, TransactionService $transactionService, TransactionItemService $transactionItemService, AuthenticateService $authenticateService) 
    {
        $this->medicineService = $medicineService;
        $this->CategoryService = $CategoryService;
        $this->batchDrugsService = $batchDrugsService;
        $this->transactionService = $transactionService;
        $this->transactionItemService = $transactionItemService;
        $this->authenticateService = $authenticateService;
    }   


    public function dashboard(){
        $allTransactionOut = $this->transactionService->findAllOutgoing()->count();
        $paidTransaction = $this->transactionService->findStatusTransactionOutgoing("paid")->count();
        $arrearsTransaction = $this->transactionService->findStatusTransactionOutgoing("arrears")->count();

        $allMedicine = $this->medicineService->findAll()->count();
        $totalStockBatch = $this->batchDrugsService->calculateBatchStock();
        $expiredStockBatch = $this->batchDrugsService->calculateBatchStock("expired");
        $usableStockBatch = $this->batchDrugsService->calculateBatchStock("usable");
        $ateStockBatch = $this->batchDrugsService->calculateBatchStock("ate");
        
        $data = [
            "all_transaction" => $allTransactionOut,
            "paid_transaction" => $paidTransaction,
            "paid_transaction_percent" => $allTransactionOut > 0 ? round(($paidTransaction / $allTransactionOut * 100)) : 0,
            "arrears_transaction" => $arrearsTransaction,
            "arrears_transaction_percent" => $allTransactionOut > 0 ? round(($arrearsTransaction / $allTransactionOut * 100)) : 0,
            "all_medicine" => $allMedicine,
            "expired_batch_stock" => $expiredStockBatch,
            "expired_batch_stock_percent" => $totalStockBatch > 0? round(($expiredStockBatch / $totalStockBatch * 100)) : 0,
            "usable_batch_stock" => $usableStockBatch,
            "usable_batch_stock_percent" => $totalStockBatch > 0? round(($usableStockBatch / $totalStockBatch * 100)) : 0,
            "ate_batch_stock" => $ateStockBatch,
            "ate_batch_stock_percent" => $totalStockBatch > 0? round(($ateStockBatch / $totalStockBatch * 100)) : 0,

        ];
        return view("manager.dashboard",compact("data"));
    }
//     public function editProfile()
// {
//     $user = auth()->user();
//     return view('account-manage.change-profile', compact('user'));
// }
//     protected $authService;

//     public function __construct(AuthenticateService $authService)
//     {
//         $this->authService = $authService;
//     }

//     public function updateProfile(Request $request)
//     {
       
//         $request->validate([
//             'name'  => 'required|string|max:255',
//             'email' => 'required|email',
//         ]);

//         $this->authService->updateProfile([
//             'name'  => $request->name,
//             'email' => $request->email,
//         ]);

//         return redirect()->back()->with('success', 'Profile updated successfully!');
//     }
//         public function updatePassword(Request $request)
// {
//     $request->validate([
//         'current_password' => ['required', 'string', 'min:6'],
//         'new_password' => ['required', 'string', 'min:6'],
//         'confirm_password' => ['required', 'string', 'same:new_password'],
//     ]);

//     try {
//         $this->authService->changePassword($request->only([
//             'current_password',
//             'new_password',
//             'confirm_password',
//         ]));

//         return redirect()->back()->with('success', 'Password updated successfully!');
//     } catch (ValidationException $e) {
//         return redirect()->back()->withErrors($e->errors());
//     } catch (\Exception $e) {
//         return redirect()->back()->withErrors(['error' => 'Something went wrong.']);
//     }
    
// }
public function historyTransaction(Request $request){
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = $request->status;
        $data = $this->transactionService->findAllOutgoing($startDate,$endDate,$status,10);
        return view("manager.history",compact("data"));
    }

public function DeleteHistoryTransaction ($id){
    try {
        $this->transactionService->delete($id);
        return redirect()->back()->with("success","Transaction deleted successfully");
    } catch (\Exception $e) {
        return redirect()->back()->with("error","Something went wrong". $e->getMessage());
    }
}
public function DrugList (Request $request){
    $search = $request->input('search');
    $categoryId = $request->input('category_id');
    $data = $this->medicineService->findAll(10,$search,$categoryId);
    $category = $this->CategoryService->findAll(); 
    return view("manager.DrugList", compact("data","category"));
}

public function ExpiredDrug (Request $request){
    try{
        $search = $request->input('search');
        $data = $this->medicineService->findMedicineWithExpiredBatch(10,$search);
        return view("manager.DrugExpired",compact("data"));
        }catch(\Exception $e){
            return redirect()->back()->with("error","Something went wrong");
        }
}
public function DeleteExpiredDrug($id){
    try{
        $this->batchDrugsService->delete($id);
        return redirect()->back()->with("success","Batch deleted successfully");
    }catch(\Exception $e){
        return redirect()->back()->with("error","Something went wrong");
    }
}


}


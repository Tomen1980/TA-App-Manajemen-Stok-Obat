<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use Illuminate\Http\Request;
use App\Services\MedicineMasterService;
use App\Services\CategoryService;
use App\Services\BatchDrugsService;
use App\Services\TransactionService;
use App\Services\TransactionItemService;

class EmployeeController extends Controller
{

    protected $medicineService;
    protected $CategoryService;
    protected $batchDrugsService;
    protected $transactionService;
    protected $transactionItemService;

    public function __construct(MedicineMasterService $medicineService, CategoryService $CategoryService, BatchDrugsService $batchDrugsService, TransactionService $transactionService, TransactionItemService $transactionItemService) 
    {
        $this->medicineService = $medicineService;
        $this->CategoryService = $CategoryService;
        $this->batchDrugsService = $batchDrugsService;
        $this->transactionService = $transactionService;
        $this->transactionItemService = $transactionItemService;
    }   

    public function dashboard(){
        return view("employee.dashboard");
    }

    // Drugs
    public function listdrugs(Request $request){
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $data = $this->medicineService->findAll(10,$search,$categoryId);
        $category = $this->CategoryService->findAll(); 
        return view("employee.drugs.list-drugs", compact("data","category"));
    }

    public function listBatchDrugs($id,Request $request){
        // $data = $this->medicineService->find($id);
        $data = $this->medicineService->findWithFilteredBatches($id, $request->status);
        return view("employee.drugs.list-batch-drugs",compact("data"));   
    }

    public function deleteBatchDrugs($id,$idBatch,Request $request){
        try{
            $this->batchDrugsService->delete($idBatch);
            return redirect()->back()->with("success","Successfully deleted");        
        }catch(\Exception $e){
            return redirect()->back()->with("error","Something went wrong");
        }
    }
    
    //transaction
    public function transactionOutgoing(){
        return view("employee.transaction.transaction-out");
    }

    public function transactionOutgoingAction(Request $request){
        try{
            $data = $request->validate([
                "transaction_date" => "required|date",
            ]);
            $data = $this->transactionService->create($data["transaction_date"]);
            return redirect("/employee/transaction-outgoing/".$data["id"])->with("success","");
        }catch(\Exception $e){
            return redirect()->back()->with("error","Something went wrong: ". $e->getMessage());
        }
    }

    public function transactionOutgoingForm(Request $request){
        $idParam = $request->id;
        $data = $this->transactionService->findTransactionOutgoingById($idParam);
        return view("employee.transaction.transaction-outgoing-form",compact("data","idParam"));
    }

    public function transactionOutgoingAddItem(Request $request){
        $idTransaksi = $request->id;
        $checkStatus = $this->transactionService->checkStatusTransaction($idTransaksi);
        if($checkStatus->status === "paid"){
            return redirect()->back()->with("error","Transaction has been paid");
        }
        $search = $request->input('search');
        $categoryId = $request->input('category');
        $categories = $this->CategoryService->findAll(); 
        $data = $this->medicineService->findAll(20,$search,$categoryId);
        return view("employee.transaction.item.add-item",compact("data","categories","idTransaksi"));
    }

    public function transactionOutgoingAddActionItem(Request $request){
        try{
            $idTransaksi = $request->id;
            $validatedData = $request->validate([
                "medicine_id" => "required",
                "batch_id" => "required",
                "quantity" => "required",
            ]);
            
            $data = array_merge($validatedData, ["transaction_id" => $idTransaksi]); 
            $this->transactionItemService->create($data);
            return redirect('/employee/transaction-outgoing/'.$request->id)->with("success","Successfully added");
        }catch(\Exception $e){
            return redirect()->back()->with("error","Something went wrong".$e->getMessage());
        }
    }

    public function transactionOutgoingDeleteActionItem($id,$idItem,Request $request){
        try{
            $this->transactionItemService->delete($idItem);
            return redirect()->back()->with("success","Successfully deleted item");
        }catch(\Exception $e){
            return redirect()->back()->with("error","Something went wrong");
        }
    }

    public function transactionOutgoingUpdateAction(Request $request){
        try{
            $this->transactionService->updateStatusOutgoingTransaction($request->id);
            return redirect("/")->with("success","Successfully deleted item");
        }catch(\Exception $e){
            return redirect()->back()->with("error","Something went wrong");
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MedicineMasterService;
use App\Services\CategoryService;
use App\Services\BatchDrugsService;

class EmployeeController extends Controller
{

    protected $medicineService;
    protected $CategoryService;
    protected $batchDrugsService;

    public function __construct(MedicineMasterService $medicineService, CategoryService $CategoryService, BatchDrugsService $batchDrugsService) 
    {
        $this->medicineService = $medicineService;
        $this->CategoryService = $CategoryService;
        $this->batchDrugsService = $batchDrugsService;
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
    
}

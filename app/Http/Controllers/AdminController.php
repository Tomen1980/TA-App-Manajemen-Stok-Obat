<?php

namespace App\Http\Controllers;

use App\Services\BatchDrugsService;
use App\Services\CategoryService;
use App\Services\MedicineMasterService;
use App\Services\SupplierService;
use App\Services\TransactionItemService;
use App\Services\TransactionService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $medicineService;
    protected $categoryService;
    protected $supplierService;
    protected $batchDrugsService;
    protected $transactionService;
    // protected $transactionItemService;
    protected $userService;
    public function __construct(MedicineMasterService $medicineService, CategoryService $categoryService, BatchDrugsService $batchDrugsService, TransactionService $transactionService, UserService $userService, SupplierService $supplierService){
        $this->medicineService = $medicineService;
        $this->categoryService = $categoryService;
        $this->supplierService = $supplierService;
        $this->batchDrugsService = $batchDrugsService;
        $this->transactionService = $transactionService;
        $this->userService = $userService;
        
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

        return view("admin.dashboard",compact('data'));
    }

    public function typedDrugs(Request $request){
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $data = $this->medicineService->findAll(10,$search,$categoryId);
        $category = $this->categoryService->findAll(); 
        return view("admin.drugs.typed-drugs",compact('data','category'));
    }

    public function formDrugs($id = null){
        $categories = $this->categoryService->findAll();
        $suppliers = $this->supplierService->findAll();
        if($id){
            $data = $this->medicineService->findById($id);
            return view("admin.drugs.form-drugs", compact('categories','suppliers','data','id'));
        }
        return view("admin.drugs.form-drugs", compact('categories','suppliers'));
    }

    public function drugsActionStored(Request $request){
        try{
            $validate = $request->validate([
                'name' => 'required|string|min:3',
                'price' => 'required|numeric',
                'min_stock' => 'required|numeric',
                'description' => 'required|string|min:5',
                'category_id' => 'required|numeric',
                'supplier_id' => 'required|numeric',
                'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $data = $this->medicineService->storeMedicine($validate);
            return redirect('/admin/drugs/typed')->with('success', 'Data berhasil disimpan.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function drugsActionDelete($id){
        try{
           $this->medicineService->deleteMedicine($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function drugsActionUpdate(Request $request, $id){
        try{
            $validate = $request->validate([
                'name' =>'required|string|min:3',
                'price' =>'required|numeric',
               'min_stock' =>'required|numeric',
                'description' =>'required|string|min:5',
                'category_id' =>'required|numeric',
               'supplier_id' =>'required|numeric',
                'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'old_image' => 'required|string',
            ]);
            $this->medicineService->updateMedicine($validate,$id);
            return redirect('/admin/drugs/typed')->with('success', 'Data berhasil diubah.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function batchDrugs($id, Request $request){
        $data = $this->medicineService->findWithFilteredBatches($id,$request->status);
        return view("admin.drugs.batch-drugs-list", compact('data','id'));
    }

    public function formBatchDrugs($id){
        return view("admin.drugs.form-batch-drugs", compact('id'));
    }

    public function batchDrugsActionStored($id,Request $request){
        try{
            $validate = $request->validate([
                'no_batch' =>'required|string|min:3',
                'production_date' =>'required|date',
                'expired_date' =>'required|date',
                'batch_stock' =>'required|numeric',
                'purchase_price' =>'required|numeric',
            ]);
            $this->batchDrugsService->storeBatchDrugs($validate,$id);
            return redirect('/admin/drugs/from-typed-drugs/'.$id.'/batch')->with('success', 'Data berhasil disimpan.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function listCategory(Request $request){
        $data = $this->categoryService->findAll(10,$request->search);
        return view("admin.category.list-category", compact('data'));
    }

    public function formCategory($id = null){
        if($id){
            $data = $this->categoryService->findById($id);
            return view("admin.category.form-category", compact('data','id'));
        }
        return view("admin.category.form-category");
    }
    public function categoryActionStored(Request $request){
        try{
            $validate = $request->validate([
                'name' =>'required|string|min:3'
            ]);
            $this->categoryService->create($validate);
            return redirect('/admin/category/list-category')->with('success', 'Data berhasil disimpan.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function categoryActionUpdate(Request $request, $id){
        try{
            $validate = $request->validate([
                'name' =>'required|string|min:3'
            ]);
            $this->categoryService->update($id,$validate);
            return redirect('/admin/category/list-category')->with('success', 'Data berhasil diubah.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function categoryActionDelete($id){
        try{
            $this->categoryService->delete($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function listSuppliers(Request $request){
        $data = $this->supplierService->findAll(10,$request->search);
        return view("admin.suppliers.list-suppliers", compact('data'));
    }

    public function formSuppliers($id = null){
        if($id){
            $data = $this->supplierService->findById($id);
            return view("admin.suppliers.form-suppliers", compact('data','id'));
        }
        return view("admin.suppliers.form-suppliers");
    }

    public function suppliersActionStored(Request $request){
        try{
            $validate = $request->validate([
                'name' =>'required|string|min:3',
                'address' =>'required|string|min:3',
                'contact' =>'required|numeric|min:3',
            ]);
            $this->supplierService->create($validate);
            return redirect('/admin/suppliers/list-supplier')->with('success', 'Data berhasil disimpan.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function suppliersActionUpdate($id,Request $request ){
        try{
            $validate = $request->validate([
                'name' =>'required|string|min:3',
                'address' =>'required|string|min:3',
                'contact' =>'required|numeric|min:3',
            ]);
            $this->supplierService->update($validate,$id);
            return redirect('/admin/suppliers/list-supplier')->with('success', 'Data berhasil diubah.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function suppliersActionDelete($id){
        try{
            $this->supplierService->delete($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function listUser(Request $request){
        $data = $this->userService->getAllUsers(10,$request->search);
        return view("admin.manage-user.list-user",compact('data'));
    }

    public function formUser($id = null){
        if($id){
            $data = $this->userService->getUserById($id);
            return view("admin.manage-user.form-user", compact('data','id'));
        }
        return view("admin.manage-user.form-user");
    }

    public function userActionStored(Request $request){
        try{
            $validate = $request->validate([
                'name' =>'required|string|min:8',
                'email' =>'required|email|unique:users',
                'password' =>'required|string|min:8',
                'password_confirmation' => 'required|string|min:3|same:password',
            ]);
            $this->userService->createUser($validate);
            return redirect('/admin/user/list-user')->with('success', 'Data berhasil disimpan.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userActionUpdate($id,Request $request){
        try{
            $validate = $request->validate([
                'name' =>'required|string|min:8',
                'email' =>'required|email',
                'password' =>'required|string|min:8',
                'password_confirmation' =>'required|string|min:3|same:password',
            ]);
            $this->userService->updateUser($validate,$id);
            return redirect('/admin/user/list-user')->with('success', 'Data berhasil diubah.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function userActionDelete($id){
        try{
            $this->userService->deleteUser($id);
            return redirect()->back()->with('success', 'Data berhasil dihapus.');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}



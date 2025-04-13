<?php
namespace App\Repositories;

use App\Models\MedicineMasterModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class MedicineMasterRepository {
    protected $model;

    public function __construct(MedicineMasterModel $model){
        $this->model = $model;
    }

    public function findAll(?int $page = null, $search = null, $categoryId = null){
        $query = $this->model->with("batch_drugs","category","supplier");
    
        if ($search) {
            $query->where("name", "like", "%".$search."%");
        }
        
        if ($categoryId) {
            $query->where("category_id", $categoryId);
        }
        if(isset($page)){
            return $query->paginate($page);
        }
        return $query->get();
        
    }

    public function findById(int $id){
        return $this->model->with("batch_drugs","category","supplier")->find($id);
    }

    public function findMedicineWithExpiredBatch(){
        return $this->model->with(["batch_drugs"=>function($query){
            $query->where("expired_date","<=",now()->format('Y-m-d'));
        }])->get();
    }

}
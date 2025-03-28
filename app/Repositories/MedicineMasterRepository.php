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

    public function findAll(int $page = 10, $search = null, $categoryId = null){
        $query = $this->model->query();
    
        if ($search) {
            $query->where("name", "like", "%".$search."%");
        }
        
        if ($categoryId) {
            $query->where("category_id", $categoryId);
        }
        
        return $query->paginate($page);
    }

    public function findById(int $id){
        return $this->model->with("batch_drugs","category","supplier")->find($id);
    }
}
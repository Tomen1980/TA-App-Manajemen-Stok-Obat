<?php
namespace App\Repositories;

use App\Models\SupplierModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SupplierRepositories {
    protected $model;

    public function __construct(SupplierModel $model){
        $this->model = $model;
    }

    public function findAll(?int $page = null, ?string $search = null){
        $query =  $this->model->newQuery();
    
        if ($search) {
            $query->where("name", "like", "%".$search."%");
        }
        
        if(isset($page)){
            return $query->paginate($page);
        }
        return $query->get();
    }

    public function findById(int $id){
        return $this->model->find($id);
    }

    public function create(array $data){
        return $this->model->create($data);
    }

    public function update(int $id, array $data){
        $supplier = $this->model->find($id);
        if($supplier){
            $supplier->update($data);
            return $supplier;
        }
        return null;
    }

    public function delete(int $id){
        $supplier = $this->model->find($id);
        if($supplier){
            $supplier->delete();
            return true;
        }
        return false;
    }
}
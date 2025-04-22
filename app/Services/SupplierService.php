<?php 

namespace App\Services;

use App\Repositories\SupplierRepositories;

class SupplierService{
    protected $SupplierRepositories;

    public function __construct(SupplierRepositories $SupplierRepositories)
    {
        $this->SupplierRepositories = $SupplierRepositories;
    }

    public function findAll(?int $page = null, $search = null)
    {
        return $this->SupplierRepositories->findAll($page,$search);
    }

    public function findById(int $id){
        return $this->SupplierRepositories->findById($id);
    }

    public function create(array $data){
        return $this->SupplierRepositories->create($data);
    }

    public function update(array $data, int $id){
        return $this->SupplierRepositories->update($id,$data);
    }

    public function delete(int $id){
        return $this->SupplierRepositories->delete($id);
    }
}
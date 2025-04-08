<?php
namespace App\Repositories;

use App\Models\BatchDrugsModel;

class BatchDrugsRepository {
    protected $model;

    public function __construct(BatchDrugsModel $model){
        $this->model = $model;
    }

    public function deleteById(int $id){
        return $this->model->destroy($id);
    }

    public function reduceStock(int $id, int $qty){
        return $this->model->find($id)->decrement('batch_stock', $qty);
    }
}
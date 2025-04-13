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

    public function calculateBatchStock(?string $type = null){
      
        $now = now();
        $threeMonthsLater = $now->copy()->addMonths(3);

        if($type == "expired"){
            return BatchDrugsModel::where('expired_date', '<', $now)
            ->sum('batch_stock');
        }else if( $type == 'ate'){
            return BatchDrugsModel::where('expired_date', '>=', $now)
            ->where('expired_date', '<=', $threeMonthsLater)
            ->sum('batch_stock');
        }else if( $type == 'usable'){
            return BatchDrugsModel::where('expired_date', '>', $threeMonthsLater)
            ->sum('batch_stock');
        }
        return $this->model->sum('batch_stock');
    }

    public function deleteAllExpired(){
     $expiredBatches = $this->model->where('expired_date', '<=', now())->get();
    
    foreach ($expiredBatches as $batch) {
        $batch->delete(); // Ini akan memicu event deleted
    }
    
    return $expiredBatches->count();
    }
}
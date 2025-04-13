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

    public function findMedicineWithExpiredBatch(?int $paginate = null, ?string $search = null)
        {
            $query = $this->model->whereHas('batch_drugs', function($query) {
                    $query->where('expired_date', '<=', now()->format('Y-m-d'));
                })
                ->with(['batch_drugs' => function($query) {
                    $query->where('expired_date', '<=', now()->format('Y-m-d'))
                        ->orderBy('expired_date', 'asc');
                }]);

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhereHas('batch_drugs', function($q) use ($search) {
                        $q->where('no_batch', 'like', '%'.$search.'%');
                    });
                });
            }

            if (isset($paginate)) {
                return $query->paginate($paginate);
            }
            
            return $query->get();
        }

}
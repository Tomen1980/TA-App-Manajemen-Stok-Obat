<?php
namespace App\Repositories;

use App\Enums\TransactionStatus;
use App\Models\TransactionModel;
use App\Enums\TransactionType;

use App\Models\BatchDrugsModel;
use App\Models\MedicineMasterModel;

class TransactionRepository {
    protected $model;
    protected $modelBatch;
    protected $modelMedicineMaster;

    public function __construct(TransactionModel $model, BatchDrugsModel $modelBatch, MedicineMasterModel $modelMedicineMaster){
        $this->model = $model;
        $this->modelBatch = $modelBatch;
        $this->modelMedicineMaster = $modelMedicineMaster;
    }

    public function create($date){
        return $this->model->create([
            "date"=> $date,
            "type" => TransactionType::OUT,
            "user_id" => auth()->user()->id,
        ]);
    }

    public function checkStatusTransaction($id){
        return $this->model->select("status")->find( $id );
    }

    public function findAll(string $type, ?string $startDate = null, ?string $endDate = null, ?string $status = null, ?int $paginate = null)
    {
        $query = $this->model->with("user", "transactionsItem", "transactionsItem.batchDrug", "transactionsItem.batchDrug.medicineMaster")
            ->where("type", $type);

        if ($startDate && $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $query->orderBy('date', 'desc');

        if(isset($paginate)){
            return $query->paginate($paginate);
        }else{
            return $query->get();
        }
    }

    public function findStatusTransactionOutgoing(string $type,string $status){
        $query = $this->model->with("user", "transactionsItem", "transactionsItem.batchDrug", "transactionsItem.batchDrug.medicineMaster")
            ->where("type", $type)->where("status", $status);
        return $query->get();
    }

    public function findTransactionOutgoingById(int $id){
        return $this->model->with("user","transactionsItem","transactionsItem.batchDrug","transactionsItem.batchDrug.medicineMaster")->where("type","out")->find($id);
    }

    public function updateStatusTransactionOutgoing(int $id){
         $this->model->find($id)->update([
            "status" => TransactionStatus::PAID,
        ]);
    }

    public function delete(int $id){
        $item = $this->model->find($id);
        if ($item) {
            return $item->delete();
        }
        throw new \Exception("Item not found");
    }

    public function findTransactionForBlockChain(int $id){
        return $this->model->with([
            "user" => function($query){
                $query->select("id","name");
            },
        "transactionsItem" => function($query){
            $query->select("id","transaction_id","batch_drug_id","item_amount","total_price");
        },"transactionsItem.batchDrug" => function($query){
            $query->select("id","medicine_id","no_batch");
        }
        ,"transactionsItem.batchDrug.medicineMaster" =>function ($query){
            $query->select("id","name","price");
        }
        ])
        ->select( 
            'id', // Pastikan primary key ada
        'type', 
        'total_price', 
        'status', 
        'created_at')
        ->where("type","out")->find($id);
    }

}
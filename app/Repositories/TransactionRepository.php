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

    public function findAllTransactionOutgoing(){
        return $this->model->all();
    }

    public function checkStatusTransaction($id){
        return $this->model->select("status")->find( $id );
    }

    public function findTransactionOutgoingById(int $id){
        return $this->model->with("user","transactionsItem","transactionsItem.batchDrug","transactionsItem.batchDrug.medicineMaster")->find($id);
    }

    public function updateStatusTransactionOutgoing(int $id){
         $this->model->find($id)->update([
            "status" => TransactionStatus::PAID,
        ]);

    }

}
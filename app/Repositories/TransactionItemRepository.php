<?php
namespace App\Repositories;

use App\Models\MedicineMasterModel;
use App\Models\TransactionItemModel;

class TransactionItemRepository {
    protected $model;
    protected $modelMedicine;

    public function __construct(TransactionItemModel $model, MedicineMasterModel $modelMedicine){
        $this->model = $model;
    }

    public function create(array $data){
        $medicineMasterModel = new MedicineMasterModel();
        //calculate price
        $result_price = $medicineMasterModel->select('price')->find($data["medicine_id"]);
        $total_price = $result_price["price"] * $data["quantity"];

        return $this->model->create([
            'batch_drug_id' => $data["batch_id"],
            'item_amount' => $data["quantity"],
            'total_price' => $total_price,
            'transaction_id' => $data["transaction_id"],
        ]);
    }

    public function delete(int $id){
        $item = $this->model->find($id);
        if ($item) {
            return $item->delete();
        }
        throw new \Exception("Item not found");
    }

    


}
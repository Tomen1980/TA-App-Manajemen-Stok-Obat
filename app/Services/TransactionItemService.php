<?php

namespace App\Services;

use App\Models\TransactionModel;
use App\Repositories\TransactionItemRepository;

class TransactionItemService {

    protected $TransactionItemRepository;

    public function __construct(TransactionItemRepository $TransactionItemRepository)
    {
        $this->TransactionItemRepository = $TransactionItemRepository;
    }

    public function create(array $data){
        return $this->TransactionItemRepository->create($data);
    }

    public function delete(int $id){
        return $this->TransactionItemRepository->delete($id);
    }

  
}
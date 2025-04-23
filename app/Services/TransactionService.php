<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Repositories\BatchDrugsRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TransactionService {

    protected $transactionRepository;
    protected $batchDrugsRepository;
    public function __construct(TransactionRepository $transactionRepository, BatchDrugsRepository $batchDrugsRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->batchDrugsRepository = $batchDrugsRepository;
    }

    public function create($date){
        return $this->transactionRepository->create($date);
    }

    public function findAllOutgoing( ?string $startDate = null, ?string $endDate = null, ?string $status = null, ?int $paginate = null){
        return $this->transactionRepository->findAll("out", $startDate, $endDate, $status, $paginate);
    }

    public function findStatusTransactionOutgoing(string $status){
        return $this->transactionRepository->findStatusTransactionOutgoing("out",$status);
    }

    public function findTransactionOutgoingById(int $id){
        return $this->transactionRepository->findTransactionOutgoingById($id);
    }

    public function updateStatusOutgoingTransaction(int $id){
        //tampil data transaction
        $transaction = $this->transactionRepository->findTransactionOutgoingById($id);
        // return dd($transaction->transactionsItem);
        //looping untuk batch obat
        foreach($transaction->transactionsItem as $item){
            //kurangi batch obat
            $this->batchDrugsRepository->reduceStock($item->batch_drug_id,$item->item_amount);
        }
        // update status transaction
        $this->transactionRepository->updateStatusTransactionOutgoing($id);
        $dataChain = $this->transactionRepository->findTransactionForBlockChain($id);
        Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:8080/api/blocks', [
            'data' => json_encode($dataChain),
        ]);

    }

    public function checkStatusTransaction(int $id){
        //update status transaction
        return $this->transactionRepository->checkStatusTransaction($id);
        
    }

    public function delete(int $id){
        $this->transactionRepository->delete($id);
    }

    public function findTransactionForBlockChain(int $id){
        return $this->transactionRepository->findTransactionForBlockChain($id);
    }
}
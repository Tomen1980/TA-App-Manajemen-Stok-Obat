<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Repositories\BatchDrugsRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
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

                DB::beginTransaction();

            try {
                // Ambil data transaksi
                $transaction = $this->transactionRepository->findTransactionOutgoingById($id);

                // Looping untuk kurangi stok batch obat
                foreach ($transaction->transactionsItem as $item) {
                    $this->batchDrugsRepository->reduceStock($item->batch_drug_id, $item->item_amount);
                }

                // Update status transaksi
                $this->transactionRepository->updateStatusTransactionOutgoing($id);

                // Ambil data untuk blockchain
                $dataChain = $this->transactionRepository->findTransactionForBlockChain($id);

                // Kirim ke API blockchain
                Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'KEY_API' => config('services.api-communication.token')
                ])->post(config('services.api-communication.url') . '/api/blocks', [
                    'data' => json_encode($dataChain),
                ]);

                DB::commit();

            } catch (\Throwable $e) {
                DB::rollBack();

                // Log error atau throw ulang sesuai kebutuhan
                report($e);
                throw new \Exception("Gagal memproses transaksi keluar: " . $e->getMessage());
            }

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
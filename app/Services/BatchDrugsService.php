<?php

namespace App\Services;

use App\Repositories\BatchDrugsRepository;

class BatchDrugsService {

    protected $BatchDrugsRepository;

    public function __construct(BatchDrugsRepository $BatchDrugsRepository)
    {
        $this->BatchDrugsRepository = $BatchDrugsRepository;
    }

    public function delete(int $id){
        return $this->BatchDrugsRepository->deleteById($id);
    }


    public function calculateBatchStock(?string $type = null){
        return $this->BatchDrugsRepository->calculateBatchStock($type);
    }

}
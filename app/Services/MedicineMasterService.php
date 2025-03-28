<?php

namespace App\Services;

use App\Repositories\MedicineMasterRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class MedicineMasterService {

    protected $medicinRepository;
    public function __construct(MedicineMasterRepository $medicinRepository)
    {
        $this->medicinRepository = $medicinRepository;
    }


    public function findAll(int $page = 10, $search = null, $categoryId = null){
        return $this->medicinRepository->findAll($page,$search,$categoryId);
    }

    public function find(int $id){
        return $this->medicinRepository->findById($id);
    }

    public function findWithFilteredBatches(int $id, ?string $status = null){
    $medicine = $this->medicinRepository->findById($id);
    
    if ($status) {
        $now = now();
        $medicine->batch_drugs = $medicine->batch_drugs->filter(function($batch) use ($status, $now) {
            $expiryDate = \Carbon\Carbon::parse($batch->expired_date);
            
            if ($status === 'expired') {
                return $expiryDate->isPast();
            }
            
            if ($status === 'ate') { // About to Expire
                return !$expiryDate->isPast() && $now->diffInMonths($expiryDate, false) <= 3;
            }
            
            if ($status === 'usable') {
                return !$expiryDate->isPast() && $now->diffInMonths($expiryDate, false) > 3;
            }
            
            return true;
        });
    }
    
    return $medicine;
}

}
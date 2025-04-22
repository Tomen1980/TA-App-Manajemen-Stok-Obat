<?php

namespace App\Services;

use App\Repositories\MedicineMasterRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MedicineMasterService {

    protected $medicinRepository;
    public function __construct(MedicineMasterRepository $medicinRepository)
    {
        $this->medicinRepository = $medicinRepository;
    }


    public function findAll(?int $page = null, $search = null, $categoryId = null){
        return $this->medicinRepository->findAll($page,$search,$categoryId);
    }

    public function findById(int $id){
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
    public function findMedicineWithExpiredBatch(?int $paginate = null, ?string $search = null){
        return $this->medicinRepository->findMedicineWithExpiredBatch($paginate,$search);
    }

    public function storeMedicine(array $data){

       // Handle image upload
       // Simpan ke storage/app/public/photos
       $path = $data["image"]->store('medicine', 'public');
       // Dapatkan URL public-nya
       $url = Storage::url($path);
       $data = [
           'name' => $data['name'],
           'min_stock' => $data['min_stock'],
           'price' => $data['price'],
           'description' => $data['description'],
           'image' => $url,
           'category_id' => $data['category_id'],
           'supplier_id' => $data['supplier_id']
       ];
       return $this->medicinRepository->create($data);
    }

    public function deleteMedicine(int $id){
        $data = $this->medicinRepository->findById($id);
        if(!$data){
            throw ValidationException::withMessages([
                'message' => 'Medicine not found'
            ]);
        }
        Storage::disk('public')->delete(str_replace('/storage/', '', $data->image));
        return $this->medicinRepository->delete($id);
    }

    public function updateMedicine(array $data, int $id){
        $res = $this->medicinRepository->findById($id);
        if(!$res){
            throw ValidationException::withMessages([
               'message' => 'Medicine not found'
            ]);
        }

        if(isset($data['image'])){
            Storage::disk('public')->delete(str_replace('/storage/', '', $res->image));
            $path = $data["image"]->store('medicine', 'public');
            $url = Storage::url($path);
        }else{
            $url = $res->image;
        }

        $data = [
            'name' => $data['name'],
            'min_stock' => $data['min_stock'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $url,
            'category_id' => $data['category_id'],
           'supplier_id' => $data['supplier_id']
        ];
        $data = $this->medicinRepository->update($data,$id);

        return $data;
    }
}
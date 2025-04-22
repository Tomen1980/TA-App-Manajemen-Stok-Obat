<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class CategoryService {

    protected $CategoryRepository;
    public function __construct(CategoryRepository $CategoryRepository)
    {
        $this->CategoryRepository = $CategoryRepository;
    }

    public function findAll(?int $page = null, $search = null){
        return $this->CategoryRepository->findAll($page, $search);
    }

    public function findById(int $id){
        return $this->CategoryRepository->findById($id);
    }

    public function create(array $name){
        return $this->CategoryRepository->create($name);
    }
    public function update(int $id, array $data){
        return $this->CategoryRepository->update($id, $data);
    }

    public function delete(int $id){
        return $this->CategoryRepository->delete($id);
    }

}
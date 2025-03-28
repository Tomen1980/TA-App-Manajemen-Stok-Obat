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

    public function findAll(){
        return $this->CategoryRepository->findAll();
    }

}
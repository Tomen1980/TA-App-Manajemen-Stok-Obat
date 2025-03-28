<?php
namespace App\Repositories;

use App\Models\CategoryModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CategoryRepository {
    protected $model;

    public function __construct(CategoryModel $model){
        $this->model = $model;
    }

    public function findAll(){
        return $this->model->all();
    }
}
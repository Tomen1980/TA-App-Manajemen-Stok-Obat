<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository {
    protected $model;

    public function __construct(User $model) 
    { $this->model = $model; }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data){
        $user = $this->model->create($data);
    }

}

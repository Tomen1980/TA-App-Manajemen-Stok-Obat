<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

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

    public function findEmail(string $email){
        return $this->model->where("email", $email)->first();
    }

    public function updateProfile(array $data){
        $user = $this->model->find(Auth::user()->id);
        $user->email = $data["email"];
        $user->name = $data["name"];
        $user->save();
    }

    public function updatePassword(array $data){
        $user = $this->model->find(Auth::user()->id);
        $user->password = bcrypt($data["password"]);
        $user->save();
    }
}

<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserRepository {
    protected $model;

    public function __construct(User $model) 
    { $this->model = $model; }

    public function all(?int $page = null, ?string $search = null)
    {

        $query =  $this->model->newQuery();
    
        if ($search) {
            $query->where("name", "like", "%".$search."%")->where("id","!=",Auth::user()->id);;
        }else{
            $query->where("id","!=",Auth::user()->id);
        }
        
        if(isset($page)){
            return $query->paginate($page);
        }
        return $query->get();
    }

    public function create(array $data){
        return $this->model->create($data);
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

    public function find(int $id){
        return $this->model->find($id);
    }

    public function update(array $data, int $id){
        $user = $this->model->find($id);
        $user->name = $data["name"];
        $user->email = $data["email"];
        $user->password = bcrypt($data["password"]);
        $user->save();
    }

    public function delete(int $id){
        $user = $this->model->find($id);
        $user->delete();
    }
}

<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Suppport\Collection;

class UserService {
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(){
        return $this->userRepository->all();
    }

    public function createUsers(array $data){
        try{
            $user = $this->userRepository->create($data);
            return $user;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    
}
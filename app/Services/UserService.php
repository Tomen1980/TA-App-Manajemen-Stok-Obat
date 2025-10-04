<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(){
        return $this->userRepository->all();
    }

    public function getUserbyId($id){
        return $this->userRepository->getById($id);
    }

    public function createUsers(array $data){
        try{
            $user = $this->userRepository->create($data);
            return $user;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function deleteUser($id)
    {
        try {
            return $this->userRepository->delete($id);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateUser($id, array $data){
        try{
            $user = $this->userRepository->update($id, $data);
            return $user;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
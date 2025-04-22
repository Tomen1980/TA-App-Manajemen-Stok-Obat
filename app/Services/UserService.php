<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService {
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(?int $page = null, $search = null){
        return $this->userRepository->all($page,$search);
    }

    public function createUser(array $data){
            $emailcheck = $this->userRepository->findEmail($data['email']);
            if($emailcheck){
                throw new \Exception('Email already exists');
            }
            if($data['password'] != $data['password_confirmation']){
                throw new \Exception('Password does not match');
            }

            $bcrypt = bcrypt($data['password']);
            $data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $bcrypt
            ];
            $user = $this->userRepository->create($data);
    }

    public function getUserById(int $id){
        $user = $this->userRepository->find($id);
        return $user;
    }

    public function updateUser(array $data, int $id){
        $user = $this->userRepository->find($id);
        if(!$user){
            throw new \Exception('User not found');
        }
        if($data['password']!= $data['password_confirmation']){
            throw new \Exception('Password does not match');
        }
        if($data['email']!= $user->email){
            $emailcheck = $this->userRepository->findEmail($data['email']);
            if($emailcheck){
                throw new \Exception('Email already exists');
            }
        }
        $bcrypt = bcrypt($data['password']);
        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $bcrypt
        ];

        $user->update($data);
        return $user;
    }

    public function deleteUser(int $id){
        $user = $this->userRepository->delete($id);

    }

    
}
<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthenticateService {

    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function AuthenticateService(string $email, string $password ){
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            
            return Auth::user()->role;
        }
        throw ValidationException::withMessages([
            'message' => 'Email atau password salah.',
        ]);

    }

    public function updateProfile(array $data){
        if(Auth::user()->email == $data['email']){
            return $this->userRepository->updateProfile($data);
        }
        $checkEmail = $this->userRepository->findEmail($data["email"]);
        if($checkEmail){
            throw ValidationException::withMessages([
                'message' => 'Email has been taken',
            ]);
        }
        return $this->userRepository->updateProfile($data);
    }

    public function changePassword(array $data){
        $user = Auth::user();
        
        if (!password_verify($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Current password is incorrect',
            ]);
        }
        if ($data['new_password'] !== $data['confirm_password']) {
            throw ValidationException::withMessages([
                'new_password' => 'Password confirmation does not match',
            ]);
        }
        return $this->userRepository->updatePassword([
            'password' => $data['new_password'],
        ]);
    }

}
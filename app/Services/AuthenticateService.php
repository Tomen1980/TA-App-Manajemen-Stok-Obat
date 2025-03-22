<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthenticateService {

    public function AuthenticateService(string $email, string $password ){
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            
            return Auth::user()->role;
        }
        throw ValidationException::withMessages([
            'message' => 'Email atau password salah.',
        ]);

    }

}
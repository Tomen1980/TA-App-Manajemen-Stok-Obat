<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=> "Admin",
            "email" => "admin@mail.com",
            "role" => UserRole::ADMIN,
            "password" => bcrypt("JohnDev1!"),
        ]);   
        
        User::create([
            "name"=> "Employee",
            "email" => "employee@mail.com",
            "role" => UserRole::EMPLOYEE,
            "password" => bcrypt("JohnDev1!"),
        ]);   
       
        User::create([
            "name"=> "Manager",
            "email" => "manager@mail.com",
            "role" => UserRole::MANAGER,
            "password" => bcrypt("JohnDev1!"),
        ]);   
    }
}

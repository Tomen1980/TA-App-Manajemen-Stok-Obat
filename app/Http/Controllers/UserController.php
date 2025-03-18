<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    //
    public function index(){
        $users = $this->userService->getAllUsers();
        return view('users.index', compact('users'));
    }

    public function create(Request $request){
        return view("users.create");
    }

    public function store(Request $request){

        try{
            $data =  $request->validate([
                 'name' => 'required|min:3',
                 'email' => 'required|email|unique:users',
                 'password' => 'required|min:6',
             ]);
            $this->userService->createUsers($data);
            return redirect("users/create")->with('success', 'User created successfully.');
        }catch(Exception $e){
            return redirect("users/create")->with('error', $e->getMessage());
        }
    }

}

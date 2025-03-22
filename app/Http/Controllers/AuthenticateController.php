<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Services\AuthenticateService;
use Illuminate\Support\Facades\Auth;

class AuthenticateController extends Controller
{
    protected $authService;
    public function __construct(AuthenticateService $authenticateService){
        $this->authService = $authenticateService;
    }

    public function login (Request $request){
        return view('auth.login');
    }

    public function loginAction(Request $request ){
        try{
            $request->validate([
                'email'=> 'required|email',
                'password'=> 'required'
            ]);
           $res = $this->authService->AuthenticateService($request->email, $request->password);
           $request->session()->regenerate();
           
            if($res->value == UserRole::ADMIN->value ){
                return redirect()->route('admin.dashboard')->with('success','Login Successful');
            }else if($res->value == UserRole::EMPLOYEE->value){
                return redirect()->route('employee.dashboard')->with('success','Login Successful');
            }else if($res->value == UserRole::MANAGER->value){
                return redirect()->route('manager.dashboard')->with('success','Login Successful');
            }else {
                return redirect()->back()->with('error', 'Login failed');
            }
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function logout(Request $request){
        try{
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')->with('success','Logout Successful');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


}

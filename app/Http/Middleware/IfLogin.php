<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IfLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user()->role->value;
            if ($user == UserRole::EMPLOYEE->value) {
                return redirect()->route('employee.dashboard');
            } else if ($user == UserRole::ADMIN->value) {
                return redirect()->route('admin.dashboard');
            } else if ($user == UserRole::MANAGER->value) {
                return redirect()->route('manager.dashboard');
            }
        }

        return $next($request);
    }
}

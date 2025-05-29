<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;
class AdminAuthController extends Controller
{
    //show
    public function showLoginForm()
    {
        return Inertia::render('Admin/Auth/Login');
    }
    //login
    public function login(Request $request)
    {
        //check if the user is an admin and redirect account
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password,'isAdmin'=>1]))
        {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->with('error','Invalid credentials.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        return redirect()->route('admin.login');
    }
}

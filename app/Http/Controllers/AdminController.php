<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function Index(){
        return view('admin.admin_login');
    }

    public function Dashboard(){
        return view('admin.index');
    }

    public function Login(Request $request){

        $check = $request->all();
        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])){
            return redirect()->route('admin.dashboard')->with('error', 'Admin Login Success');

        }
        else{
            return redirect()->back()->with('error', 'Admin Login Failed');

        }

    }

    public function AdminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('login_form')->with('error', 'Admin Logout Success');
    }


    public function AdminRegister(){
        return view('admin.admin_register');

    }

    public function AdminRegisterCreate(Request $request){

        Admin::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            
        ]);
        return redirect()->route('login_form')->with('error', 'Admin Register Success');

    }
}

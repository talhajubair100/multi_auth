<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    
    public function Index(){

        return view('seller.seller_login');

    }

    public function SellerDashboard(){

        return view('seller.index');

    }

    public function SellerLogin(Request $request){

        $check = $request->all();
        if (Auth::guard('seller')->attempt(['email' => $check['email'], 'password' => $check['password']])){
            return redirect()->route('seller.dashboard')->with('error', 'Seller Login Success');

        }
        else{
            return redirect()->back()->with('error', 'Seller Login Failed');

        }

    }

    public function SellerLogout(){
        Auth::guard('seller')->logout();
        return redirect()->route('seller_login_form')->with('error', 'Seller Logout Success');
    }


    public function SellerRegister(){
        return view('seller.seller_register');

    }

    public function SellerRegisterCreate(Request $request){

        Seller::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
            
        ]);
        return redirect()->route('seller_login_form')->with('error', 'Seller Register Success');

    }
}

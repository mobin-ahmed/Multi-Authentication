<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
class AdminController extends Controller
{
    public function adminLogin(){
        return view('backend.admin.admin_login');
    }

    public function doLogin(Request $req){
        $req->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('admin')->attempt(['email' => $req->email, 'password' => $req->password])){
            return redirect('/dashboard');
        }
        else{
            Session::flash('error-msg', 'inavalid email and password');
            return redirect()->back();
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}

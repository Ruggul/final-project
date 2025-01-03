<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {
        $usertype=Auth::user()->usertype;

        if($usertype=='0'){
            return view('user.home');
        }elseif($usertype=='1'){
            return view('admin.home');
        }elseif($usertype=='2'){
            return view('factory.home');
        }else{
            return view('landingPage');
        }
    }
}

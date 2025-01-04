<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LastLoginController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'usertype', 'last_login', 'is_online')
                    ->orderBy('last_login', 'desc')
                    ->paginate(10);

        return view('admin.components.last-login', compact('users'));
    }
} 
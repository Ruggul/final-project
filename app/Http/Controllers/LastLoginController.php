<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LastLoginController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'usertype', 'last_login', 'is_online')
                    ->orderBy('last_login', 'desc')
                    ->paginate(10);

        return view('livewire.factory.last-login', compact('users'));
    }
} 
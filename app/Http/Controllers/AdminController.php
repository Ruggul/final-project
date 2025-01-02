<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.home', compact('users'));
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }
}

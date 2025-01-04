<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getTotalUsers()
    {
        $totalUsers = User::count();
        return response()->json(['total' => $totalUsers]);
    }

    public function getTotalProducts()
    {
        $totalProducts = Item::count();
        return response()->json(['total' => $totalProducts]);
    }

    public function getTotalStock()
    {
        try {
            $totalStock = Item::sum('stok');
            return response()->json(['total' => $totalStock]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getLowStock()
    {
        try {
            $lowStock = Item::where('stok', '<', 10)->count();
            return response()->json(['total' => $lowStock]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getProducts()
    {
        try {
            $products = Item::all();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

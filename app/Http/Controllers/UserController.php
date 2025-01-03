<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home()
    {
        Mengambil produk untuk flash sale
        $flashSaleProducts = Product::inRandomOrder()
            ->limit(6)
            ->get();

        // Mengambil produk untuk rekomendasi
        $recommendedProducts = Product::inRandomOrder()
            ->limit(12)
            ->get();

        return view('user.home', compact('flashSaleProducts', 'recommendedProducts'));
    }
}
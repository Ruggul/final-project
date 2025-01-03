<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        // Mengambil data produk untuk halaman home user
        if($usertype == '0') {
            // Mengambil data untuk flash sale
            $flashSaleProducts = Item::where('kode_barang', 'like', 'BB%')
                ->inRandomOrder()
                ->limit(6)
                ->get();

            // Mengambil data untuk rekomendasi
            $recommendedProducts = Item::inRandomOrder()
                ->limit(12)
                ->get();

            return view('user.home', compact('flashSaleProducts', 'recommendedProducts'));
        }
        elseif($usertype == '1') {
            return view('admin.home');
        }
        elseif($usertype == '2') {
            return view('factory.home');
        }
        else {
            return view('landingPage');
        }
    }
}

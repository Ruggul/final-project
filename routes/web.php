<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

use App\Http\Controllers\userCartManagement\CartController;

Route::prefix('keranjang')->group(function () {
    Route::get('/{id_pengguna}', [CartController::class, 'show']); // Menampilkan isi keranjang
    Route::post('/tambah', [CartController::class, 'addToCart']); // Menambahkan produk ke keranjang
    Route::delete('/hapus', [CartController::class, 'removeFromCart']); // Menghapus produk dari keranjang
    Route::delete('/kosongkan/{id_pengguna}', [CartController::class, 'clearCart']); // Mengosongkan keranjang
    Route::get('/total/{id_pengguna}', [CartController::class, 'calculateTotal']); // Menghitung total harga
    Route::put('/keranjang/perbarui', [CartController::class, 'updateQuantity']); // Memperbarui kuantitas produk
});
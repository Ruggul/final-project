<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventoryController;

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

// rayhan
Route::get('/', function () {
    return view('landingPage');
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

// rayhan
Route::get('/redirect',[HomeController::class,'redirect']);

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');

Route::get('/admin/users', [AdminController::class, 'getUsers'])->name('admin.users');

Route::get('/admin/total-users', [AdminController::class, 'getTotalUsers'])->name('admin.total-users');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//dhafin
use App\Http\Controllers\userCartManagement\CartController;

Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::prefix('keranjang')->group(function () {
    Route::get('/{id_pengguna}', [CartController::class, 'show']); // Menampilkan isi keranjang
    Route::post('/tambah', [CartController::class, 'addToCart']); // Menambahkan produk ke keranjang
    Route::delete('/hapus', [CartController::class, 'removeFromCart']); // Menghapus produk dari keranjang
    Route::delete('/kosongkan/{id_pengguna}', [CartController::class, 'clearCart']); // Mengosongkan keranjang
    Route::get('/total/{id_pengguna}', [CartController::class, 'calculateTotal']); // Menghitung total harga
    Route::put('/keranjang/perbarui', [CartController::class, 'updateQuantity']); // Memperbarui kuantitas produk
});

// hasan
Route::prefix('inventory')->group(function () {
    // Tampilan utama inventory
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    
    // Search route harus di atas route dengan parameter
    Route::get('/search', [InventoryController::class, 'search'])->name('inventory.search');
    
    // Route untuk tambah barang baru
    Route::post('/', [InventoryController::class, 'tambahBarang'])->name('inventory.store');
    
    // Route untuk edit, update, dan delete
    Route::get('/{item}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/{item}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    
    // Route untuk barang masuk dan keluar
    Route::post('/{item}/masuk', [InventoryController::class, 'barangMasuk'])->name('inventory.masuk');
    Route::post('/{item}/keluar', [InventoryController::class, 'barangKeluar'])->name('inventory.keluar');
});





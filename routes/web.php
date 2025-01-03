<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;


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
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;

// Route untuk homepage
Route::get('/', [UserController::class, 'home'])->name('user.home');
// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');





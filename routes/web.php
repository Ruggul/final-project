<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FactoryUserController;
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

Route::get('/redirect', [HomeController::class, 'redirect'])->name('redirect');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.home');

Route::get('/admin/users', [AdminController::class, 'getUsers'])->name('admin.users');

Route::get('/admin/total-users', [AdminController::class, 'getTotalUsers'])->name('admin.total-users');

Route::get('/admin/total-products', [AdminController::class, 'getTotalProducts'])->name('admin.total-products');

Route::get('/admin/total-stock', [AdminController::class, 'getTotalStock'])->name('admin.total-stock');

Route::get('/admin/low-stock', [AdminController::class, 'getLowStock'])->name('admin.low-stock');

Route::get('/admin/products', [AdminController::class, 'getProducts'])->name('admin.products');

Route::get('/admin/products/{id}', [AdminController::class, 'getProduct'])->name('admin.products.get');
Route::put('/admin/products/{id}', [AdminController::class, 'updateProduct'])
    ->name('admin.products.update')
    ->middleware(['auth']);
Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//dhafin

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/orders/{order}', [CartController::class, 'showOrder'])->name('orders.show');
Route::get('/checkout/{order_id}', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('payments.checkout');
Route::post('/payments/process', [App\Http\Controllers\PaymentController::class, 'process'])->name('payments.process');
Route::get('/payments/{payment}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');

// hasan
Route::prefix('inventory')->middleware(['auth'])->group(function () {
    Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/{item}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/{item}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/{item}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::get('/history', [InventoryController::class, 'history'])->name('inventory.history');
    Route::resource('inventory', InventoryController::class);
    });

//iky


    // TopUp Routes
    Route::prefix('topups')->group(function () {
        // Show topup history
        Route::get('/', [TopUpController::class, 'index'])->name('topups.index');

        // Show topup form
        Route::get('/create', [TopUpController::class, 'create'])->name('topups.create');

        // Process topup
        Route::post('/', [TopUpController::class, 'store'])->name('topups.store');

        // Show topup detail
        Route::get('/{topup}', [TopUpController::class, 'show'])->name('topups.show');

        // Cancel topup (if pending)
        Route::delete('/{topup}', [TopUpController::class, 'cancel'])->name('topups.cancel');

        // Verify payment
        Route::post('/{topup}/verify', [TopUpController::class, 'verify'])->name('topups.verify');
});

//kevin
    // Document Routes
    Route::prefix('documents')->group(function () {
        // List view documents
        Route::get('/', [DocumentController::class, 'index'])
            ->name('documents.index');


        // Create new document
        Route::get('/create', [DocumentController::class, 'create'])
            ->name('documents.create');
        
        // Store new document
        Route::post('/', [DocumentController::class, 'store'])
            ->name('documents.store');

        // Show document details
        Route::get('/{document}', [DocumentController::class, 'show'])
            ->name('documents.show');

        // Edit document form
        Route::get('/{document}/edit', [DocumentController::class, 'edit'])
            ->name('documents.edit');

        // Update document
        Route::put('/{document}', [DocumentController::class, 'update'])
            ->name('documents.update');

        // Delete document
        Route::delete('/{document}', [DocumentController::class, 'destroy'])
            ->name('documents.destroy');
});









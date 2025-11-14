<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Customer Controllers
use App\Http\Controllers\Customer\MenuController as CustomerMenuController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TableController as AdminTableController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Superadmin Controllers
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDashboardController;
use App\Http\Controllers\Superadmin\AdminManagementController as SuperadminAdminManagementController;


/*
|--------------------------------------------------------------------------
| Customer (Guest) Routes
|--------------------------------------------------------------------------
*/

Route::name('customer.')->group(function () {
    Route::get('/', [CustomerMenuController::class, 'index'])->name('menu');
    Route::post('/select-table', [CustomerMenuController::class, 'storeTable'])->name('select.table.store');
    
    // RUTE BARU UNTUK "GANTI MEJA"
    Route::get('/clear-table', [CustomerMenuController::class, 'clearTable'])->name('select.table.clear');

    // Rute Keranjang (Cart)
    Route::post('/cart/add', [CustomerOrderController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update', [CustomerOrderController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove', [CustomerOrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart/get', [CustomerOrderController::class, 'getCart'])->name('cart.get');
    
    // Rute Checkout
    Route::get('/checkout', [CustomerOrderController::class, 'checkout'])->name('checkout');
    Route::post('/order', [CustomerOrderController::class, 'store'])->name('order.store');
    Route::get('/order/{order}/payment', [CustomerOrderController::class, 'payment'])->name('order.payment');
    Route::get('/order/{order}/success', [CustomerOrderController::class, 'success'])->name('order.success');
    Route::post('/order/{order}/check-payment', [CustomerOrderController::class, 'checkPaymentStatus'])->name('order.check_payment');
    Route::post('/order/webhook/qris', [CustomerOrderController::class, 'webhook'])->name('order.webhook'); 
});


/*
|--------------------------------------------------------------------------
| Rute Admin & Superadmin (Wajib Login)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Rute Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute default /dashboard (Pintar)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role == 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }
        if ($user->role == 'admin') {
            if ($user->is_approved) {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect('/login')->with('error', 'Akun Anda sedang ditinjau oleh Superadmin.');
            }
        }
        return redirect()->route('customer.menu');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Grup untuk ADMIN dan SUPERADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
        
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('products', AdminProductController::class)->except(['show']);
        
        // RUTE BARU UNTUK CRUD MEJA
        Route::resource('tables', AdminTableController::class)->except(['show']);

        // Manajemen Order
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::post('orders/{order}/confirm-cash', [AdminOrderController::class, 'confirmCashPayment'])->name('orders.confirm_cash');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

        // Laporan
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    });


    /*
    |--------------------------------------------------------------------------
    | Grup *HANYA* untuk SUPERADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('dashboard');
        Route::get('admins', [SuperadminAdminManagementController::class, 'index'])->name('admins.index');
        Route::post('admins/{user}/approve', [SuperadminAdminManagementController::class, 'approve'])->name('admins.approve');
        Route::post('admins/{user}/password', [SuperadminAdminManagementController::class, 'changePassword'])->name('admins.password.change');
        Route::delete('admins/{user}', [SuperadminAdminManagementController::class, 'destroy'])->name('admins.destroy');
    });
});


// Rute Auth Bawaan Breeze
require __DIR__.'/auth.php';
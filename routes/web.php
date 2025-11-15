<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

// ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;

// VENDOR
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorOrderController;

// CUSTOMER
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\ReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Semua route aplikasi Laravel Marketplace.
|
*/

Route::redirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'vendor' => redirect()->route('vendor.dashboard'),
            default => redirect()->route('customer.dashboard'),
        };
    })->name('dashboard');

    // ADMIN ROUTES
    Route::middleware(['auth', 'verified', 'role:admin'])
        ->prefix('admin')
        ->as('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::resource('/categories', CategoryController::class)->names('categories');
            Route::resource('/products', AdminProductController::class)->names('products');
            Route::patch('/products/{id}/restore', [AdminProductController::class, 'restore'])->name('products.restore');
            Route::delete('/products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])->name('products.forceDelete');
            Route::resource('/users', AdminUserController::class)->names('users');
            Route::resource('/orders', AdminOrderController::class)->only(['index', 'show', 'update'])->names('orders');
            Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

        });

    // VENDOR ROUTES
    Route::middleware(['auth', 'role:vendor'])
        ->prefix('vendor')
        ->as('vendor.')
        ->group(function () {
            Route::get('/dashboard', [VendorController::class, 'index'])->name('dashboard');
            Route::resource('/products', VendorProductController::class)->names('products');
            Route::resource('/orders', VendorOrderController::class)->names('orders');
        });

    // CUSTOMER ROUTES
    Route::middleware(['auth', 'verified', 'role:customer'])
        ->prefix('customer')
        ->as('customer.')
        ->group(function () {
            Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
            Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');

            Route::controller(CartController::class)->prefix('cart')->as('cart.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::patch('/update/{product}', 'update')->name('update');
                Route::post('/add/{product}', 'add')->name('add');
                Route::delete('/remove/{product}', 'remove')->name('remove');
                Route::get('/checkout/{product}', 'showCheckoutItem')->name('showCheckoutItem');
                Route::get('/checkout', 'showCheckout')->name('showCheckout');
                Route::post('/checkout', 'checkout')->name('checkout');
            });

            Route::controller(CustomerOrderController::class)->prefix('orders')->as('orders.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{order}', 'show')->name('show');
                Route::patch('/{order}/cancel', 'cancel')->name('cancel');
                Route::get('/{order}/pay', 'showPayment')->name('pay.show');
                Route::post('/{order}/pay', 'pay')->name('pay');
            });

            Route::get('/reviews/{orderItem}/create', [ReviewController::class, 'create'])
                ->name('reviews.create');

            Route::post('/reviews/{orderItem}', [ReviewController::class, 'store'])
                ->name('reviews.store');

            });

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

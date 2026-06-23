<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\GrnController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
    });

    Route::resource('users', UserController::class)->middleware('role:admin');
    Route::resource('roles', RoleController::class)->middleware('role:admin');

    Route::resource('categories', CategoryController::class)->middleware('role:admin,manager');
    Route::resource('products', ProductController::class)->middleware('role:admin,manager');
    Route::resource('suppliers', SupplierController::class)->middleware('role:admin,manager');

    Route::prefix('purchases')->name('purchases.')->middleware('role:admin,manager')->group(function () {
        Route::get('/', [PurchaseOrderController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseOrderController::class, 'create'])->name('create');
        Route::post('/', [PurchaseOrderController::class, 'store'])->name('store');
        Route::get('/{id}', [PurchaseOrderController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [PurchaseOrderController::class, 'approve'])->name('approve');
        Route::post('/{id}/cancel', [PurchaseOrderController::class, 'cancel'])->name('cancel');
    });

    Route::prefix('grn')->name('grn.')->middleware('role:admin,manager,storekeeper')->group(function () {
        Route::get('/', [GrnController::class, 'index'])->name('index');
        Route::get('/create', [GrnController::class, 'create'])->name('create');
        Route::post('/', [GrnController::class, 'store'])->name('store');
        Route::get('/{id}', [GrnController::class, 'show'])->name('show');
    });

    Route::prefix('inventory')->name('inventory.')->middleware('role:admin,manager,storekeeper')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/movements', [InventoryController::class, 'movements'])->name('movements');
        Route::get('/adjust', [InventoryController::class, 'adjustForm'])->name('adjust-form');
        Route::post('/adjust', [InventoryController::class, 'adjust'])->name('adjust');
    });

    Route::prefix('sales')->name('sales.')->middleware('role:admin,manager,cashier')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/pos', [SaleController::class, 'pos'])->name('pos');
        Route::post('/', [SaleController::class, 'store'])->name('store');
        Route::get('/{id}', [SaleController::class, 'show'])->name('show');
        Route::get('/{id}/receipt', [SaleController::class, 'receipt'])->name('receipt');
    });

    Route::prefix('reports')->name('reports.')->middleware('role:admin,manager')->group(function () {
        Route::get('/daily', [ReportController::class, 'dailySales'])->name('daily');
        Route::get('/monthly', [ReportController::class, 'monthlySales'])->name('monthly');
        Route::get('/inventory', [ReportController::class, 'inventoryReport'])->name('inventory');
    });
});

<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuditController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

// Home page
Route::get('/', function () {
    return redirect()->route('register');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Orders
    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);

    // Product images
    Route::get('/products/image/{filename}', [ProductController::class, 'displayImage'])
        ->name('products.image');
});

// Admin-only routes
Route::group(['middleware' => ['auth', RoleMiddleware::class . ':admin']], function () {
    // Products management
    Route::resource('products', ProductController::class);

    // Audit logs
    Route::get('/audit/logs', [AuditController::class, 'index'])
        ->name('audit.logs');
});

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\AuditController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', RoleMiddleware::class . ':admin']], function () {
    Route::resource('products', ProductController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('orders', OrderController::class)->only(['index','create','store','show']);
});

Route::get('/products/image/{filename}', [ProductController::class, 'displayImage'])
    ->middleware('auth')
    ->name('products.image');

Route::get('/audit/logs', [AuditController::class, 'index'])
    ->middleware('auth')
    ->name('audit.logs');



require __DIR__.'/auth.php';

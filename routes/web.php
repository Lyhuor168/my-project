<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\ProductController;

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'getdata2'])->name('product.index');
    Route::get('/products/create', [ProductController::class, 'formProduct'])->name('product.create');
    Route::post('/products', [ProductController::class, 'save'])->name('product.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
});

use App\Http\Controllers\PosController;

Route::middleware('auth')->group(function () {
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/pos/invoice/{id}', [App\Http\Controllers\PosController::class, 'invoice'])->name('pos.invoice');
});

Route::get('/lyout', function () {
    return view('layout');
});
Route::middleware('auth')->group(function () {
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
});

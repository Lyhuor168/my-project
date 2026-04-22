<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    $products = \App\Models\Product::paginate(5);
    return view('home', compact('products'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/products', [ProductController::class, 'getdata2'])->middleware(['auth']);
Route::get('/show-products', [ProductController::class, 'getdata'])->middleware(['auth']);
Route::get('/show-products2', [ProductController::class, 'getdata2'])->middleware(['auth']);

require __DIR__.'/auth.php';

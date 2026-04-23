<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiceTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('menus', MenuController::class)->except(['show']);
    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store']);

    // Rice Type Management Routes
    Route::prefix('rice')->name('rice.')->group(function () {
        Route::get('/', [RiceTypeController::class, 'index'])->name('index');
        Route::get('/create', [RiceTypeController::class, 'create'])->name('create');
        Route::post('/', [RiceTypeController::class, 'store'])->name('store');
        Route::get('/{riceType}/edit', [RiceTypeController::class, 'edit'])->name('edit');
        Route::put('/{riceType}', [RiceTypeController::class, 'update'])->name('update');
        Route::delete('/{riceType}', [RiceTypeController::class, 'destroy'])->name('destroy');
        Route::get('/{riceType}/add-stock', [RiceTypeController::class, 'addStock'])->name('add-stock');
        Route::post('/{riceType}/add-stock', [RiceTypeController::class, 'storeStock'])->name('store-stock');
    });

    Route::get('orders/{order}/payment', [PaymentController::class, 'create'])->name('orders.payment.create');
    Route::post('orders/{order}/payment', [PaymentController::class, 'store'])->name('orders.payment.store');
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

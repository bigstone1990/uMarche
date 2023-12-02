<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('User/Welcome', [
        'canLogin' => Route::has('user.login'),
        'canRegister' => Route::has('user.register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'checkLogin' => Auth::guard('users')->check(),
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('User/Dashboard');
// })->middleware(['auth:users', 'verified'])->name('dashboard');

Route::middleware('auth:users')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth:users')->group(function() {
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
    Route::get('show/{item}', [ItemController::class, 'show'])->name('items.show');
});

Route::prefix('cart')->middleware('auth:users')->group(function() {
    Route::post('add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::delete('delete/{item}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('success', [CartController::class, 'success'])->name('cart.success');
    Route::get('cancel', [CartController::class, 'cancel'])->name('cart.cancel');
});

require __DIR__.'/auth.php';

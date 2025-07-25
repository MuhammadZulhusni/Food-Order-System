<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

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

require __DIR__.'/auth.php';


// Group for admin routes with the '/admin' prefix
Route::prefix('admin')->group(function () {
    // Public admin routes (no middleware)
    Route::get('/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
    Route::post('/login_submit', [AdminController::class, 'AdminLoginSubmit'])->name('admin.login_submit');
    // Protected admin routes
    Route::middleware('admin')->group(function(){
        Route::get('/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
        Route::get('/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    });

});


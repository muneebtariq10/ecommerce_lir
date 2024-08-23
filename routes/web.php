<?php

use App\Http\Controllers\Admin\BackendboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

use App\Http\Middleware\IsAdmin;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', [BackendboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('admin/role', RoleController::class);
    Route::resource('admin/user', UserController::class);

    Route::resource('admin/brand', BrandController::class);
    Route::resource('admin/category', CategoryController::class);
    Route::resource('admin/product', ProductController::class);
});

require __DIR__.'/auth.php';
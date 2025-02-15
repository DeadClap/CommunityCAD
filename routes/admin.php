<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    // ✅ Check for specific permissions instead of roles
    Route::middleware(['can:view dashboard'])->group(function () {
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    });

    Route::middleware(['can:manage users'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    });

    Route::middleware(['can:manage roles'])->group(function () {
        Route::get('/admin/roles', [RoleController::class, 'index'])->name('admin.roles');
        Route::post('/admin/roles', [RoleController::class, 'store'])->name('admin.roles.store');
        Route::put('/admin/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('admin.roles.updatePermissions');
        Route::delete('/admin/roles/{role}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    });
});
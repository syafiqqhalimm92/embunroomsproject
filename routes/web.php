<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\VendorUserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/notifications', fn () => view('pages.notifications'))->name('notifications');
    Route::get('/tasks', fn () => view('pages.tasks'))->name('tasks');
    Route::get('/tenant', fn () => view('pages.tenant'))->name('tenant');
    Route::get('/chat', fn () => view('pages.chat'))->name('chat');

    // Admin management
    Route::get('/admin', [AdminUserController::class, 'index'])->name('admin.index');
    Route::get('/admin/create', [AdminUserController::class, 'create'])->name('admin.create');
    Route::post('/admin', [AdminUserController::class, 'store'])->name('admin.store');
    Route::get('/admin/{user}/edit', [AdminUserController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/{user}', [AdminUserController::class, 'update'])->name('admin.update');
    Route::post('/admin/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('admin.resetPassword');

    // Vendor management
    Route::get('/vendor', [VendorUserController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/create', [VendorUserController::class, 'create'])->name('vendor.create');
    Route::post('/vendor', [VendorUserController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/{user}/edit', [VendorUserController::class, 'edit'])->name('vendor.edit');
    Route::put('/vendor/{user}', [VendorUserController::class, 'update'])->name('vendor.update');
    Route::post('/vendor/{user}/reset-password', [VendorUserController::class, 'resetPassword'])->name('vendor.resetPassword');

    // Units (houses)
    Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/units/create', [UnitController::class, 'create'])->name('units.create');
    Route::post('/units', [UnitController::class, 'store'])->name('units.store');
    Route::get('/units/{house}/edit', [UnitController::class, 'edit'])->name('units.edit');
    Route::put('/units/{house}', [UnitController::class, 'update'])->name('units.update');

    // Rooms management (under a house)
    Route::get('/houses/{house}/rooms/create', [UnitController::class,'createRoom'])->name('rooms.create');
    Route::post('/houses/{house}/rooms', [UnitController::class,'storeRoom'])->name('rooms.store');

    Route::get('/houses/{house}/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/houses/{house}/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\VendorUserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\AgreementTemplateController;
use App\Http\Controllers\HouseImageController;
use App\Http\Controllers\RoomImageController;
use App\Http\Controllers\OwnerAgreementController;

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
    Route::post('/houses/{house}/rooms/{room}/images', [RoomImageController::class, 'store'])->name('rooms.images.store');
    Route::delete('/houses/{house}/rooms/{room}/images/{image}', [RoomImageController::class, 'destroy'])->name('rooms.images.destroy');

    // Rooms management (under a house)
    Route::get('/houses/{house}/rooms/create', [RoomController::class,'create'])->name('rooms.create');
    Route::post('/houses/{house}/rooms', [RoomController::class,'store'])->name('rooms.store');
    Route::get('/houses/{house}/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/houses/{house}/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/houses/{house}/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::post('/houses/{house}/images', [HouseImageController::class, 'store'])->name('houses.images.store');
    Route::delete('/houses/{house}/images/{image}', [HouseImageController::class, 'destroy'])->name('houses.images.destroy');

    // Agreement templates management
    Route::get('/agreement/template', [AgreementTemplateController::class, 'index'])->name('agreement.template');
    Route::get('/agreement/template/{template}/edit', [AgreementTemplateController::class, 'edit'])->name('agreement.template.edit');
    Route::put('/agreement/template/{template}', [AgreementTemplateController::class, 'update'])->name('agreement.template.update');
    Route::get('/agreement/template/create', [AgreementTemplateController::class, 'create'])->name('agreement.template.create');
    Route::post('/agreement/template', [AgreementTemplateController::class, 'store'])->name('agreement.template.store');
    Route::delete('/agreement/template/{template}', [AgreementTemplateController::class, 'destroy'])->name('agreement.template.destroy');
    Route::get('/agreement/template/{template}/preview', [AgreementTemplateController::class, 'preview'])->name('agreement.template.preview');

    // Owner Agreements
    Route::get('/houses/{house}/owner-agreements/create', [OwnerAgreementController::class, 'create'])->name('owner-agreements.create');
    Route::post('/houses/{house}/owner-agreements', [OwnerAgreementController::class, 'store'])->name('owner-agreements.store');
    Route::get('/houses/{house}/owner-agreements/{ownerAgreement}/edit', [OwnerAgreementController::class, 'edit'])->name('owner-agreements.edit');
    Route::put('/houses/{house}/owner-agreements/{ownerAgreement}', [OwnerAgreementController::class, 'update'])->name('owner-agreements.update');
    Route::get('/houses/{house}/owner-agreements/{ownerAgreement}/preview', [OwnerAgreementController::class, 'preview'])->name('owner-agreements.preview');
    Route::post('/houses/{house}/owner-agreements/{ownerAgreement}/owner-signature', [OwnerAgreementController::class, 'saveOwnerSignature'])->name('owner-agreements.owner-signature.store');
    Route::get('/owner-agreements/sign/{token}', [OwnerAgreementController::class, 'signPage'])->name('owner-agreements.sign-page');
    Route::post('/owner-agreements/sign/{token}', [OwnerAgreementController::class, 'submitSignature'])->name('owner-agreements.sign-submit');

});
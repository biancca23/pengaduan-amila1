<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AuthController;

// Route Public (Bisa diakses siapa saja)
Route::get('/', [AspirasiController::class, 'index'])->name('siswa.index');
Route::post('/store', [AspirasiController::class, 'store'])->name('siswa.store');

// Route Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Admin (Hanya bisa diakses jika sudah login)
Route::middleware([\App\Http\Middleware\AdminAuth::class])->group(function () {
    Route::get('/admin', [AspirasiController::class, 'adminIndex'])->name('admin.index');
    Route::post('/admin/update/{id}', [AspirasiController::class, 'updateStatus'])->name('admin.update');
});
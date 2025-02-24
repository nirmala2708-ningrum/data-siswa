<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;

// Route utama (beranda)
Route::get('/', function () {
    return view('home');
})->name('home');

// Route untuk otentikasi
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/postlogin', [AuthController::class, 'postlogin'])->name('postlogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup route yang memerlukan middleware checkRole
Route::group(['middleware' => 'checkRole'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Grup route untuk data siswa
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('index');
        Route::get('/create', [SiswaController::class, 'create'])->name('create');
        Route::post('/', [SiswaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SiswaController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [SiswaController::class, 'update'])->name('update');
        Route::get('/{id}/delete', [SiswaController::class, 'delete'])->name('delete');
        Route::get('/{id}/profile', [SiswaController::class, 'profile'])->name('profile');
        Route::post('/{id}/addnilai', [SiswaController::class, 'addNilai'])->name('addnilai');
        Route::get('edit_nilai/{id}',[SiswaController::class, 'edit_nilai'])->name('edit_nilai');
        Route::post('update_nilai/{id}',[SiswaController::class, 'update_nilai'])->name('update_nilai');

        // Route untuk mengupdate nilai siswa melalui x-editable
        Route::post('/update-nilai', [SiswaController::class, 'updateNilai'])->name('updateNilai');
    });
});

// Route untuk profil pengguna
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');


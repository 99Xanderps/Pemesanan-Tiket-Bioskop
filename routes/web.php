<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Auth\AuthController;

// ============================
// HALAMAN PUBLIK (film & beranda)
// ============================

// Halaman Beranda (List Film)
Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// Halaman Semua Film
Route::get('/film/semua', [CatalogController::class, 'all'])->name('movies.all');

// Halaman Detail Film (butuh parameter ID/Slug film)
Route::get('/movie/{movie}', [MovieController::class, 'show'])->name('movies.show');

// ============================
// AUTH (hanya untuk tamu / belum login)
// ============================

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ============================
// BOOKING (wajib login dulu)
// ============================

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman Pilih Kursi (butuh parameter ID showtime)
    Route::get('/booking/seats/{showtime}', [BookingController::class, 'seats'])->name('booking.seats');

    // Simpan Pemesanan (butuh parameter ID showtime)
    Route::post('/booking/store/{showtime}', [BookingController::class, 'store'])->name('booking.store');

    // Halaman E-Tiket (butuh parameter ID/Code booking)
    Route::get('/booking/ticket/{booking}', [BookingController::class, 'ticket'])->name('booking.ticket');
});

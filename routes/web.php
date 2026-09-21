<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\MoviePosterController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;

// ============================
// HALAMAN PUBLIK (film & beranda)
// ============================

// Halaman Beranda (List Film)
Route::get('/main', function () {
    return redirect()->route('movies.index');
});
Route::get('/', [MovieController::class, 'index'])->name('movies.index');

// Halaman Semua Film
Route::get('/film/semua', [CatalogController::class, 'all'])->name('movies.all');

// Halaman Detail Film (butuh parameter ID/Slug film)
Route::get('/movie/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Halaman Bioskop (daftar bioskop/cinema)
Route::get('/bioskop', [CatalogController::class, 'bioskop'])->name('cinemas.index');

// ============================
// AUTH USER BIASA (hanya untuk tamu / belum login)
// ============================

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ============================
// AUTH ADMIN (terpisah dari login user biasa)
// ============================

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Kelola poster film (upload/ganti gambar)
    Route::get('/admin/movies', [MoviePosterController::class, 'index'])->name('admin.movies.index');
    Route::post('/admin/movies/{movie}/poster', [MoviePosterController::class, 'update'])->name('admin.movies.updatePoster');
});

// ============================
// BOOKING & PEMBAYARAN (wajib login dulu, sebagai user)
// ============================

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman Tiket Saya (riwayat pesanan)
    Route::get('/tiket', [CatalogController::class, 'tiket'])->name('tickets.mine');

    // Halaman Pilih Kursi (butuh parameter ID showtime)
    Route::get('/booking/seats/{showtime}', [BookingController::class, 'seats'])->name('booking.seats');

    // Simpan Pemesanan (butuh parameter ID showtime)
    Route::post('/booking/store/{showtime}', [BookingController::class, 'store'])->name('booking.store');

    // Halaman Pembayaran
    Route::get('/booking/bayar/{booking}', [BookingController::class, 'pay'])->name('booking.pay');
    Route::post('/booking/bayar/{booking}', [BookingController::class, 'confirmPay'])->name('booking.confirmPay');

    // Halaman E-Tiket (butuh parameter ID/Code booking)
    Route::get('/booking/ticket/{booking}', [BookingController::class, 'ticket'])->name('booking.ticket');
});
use App\Http\Controllers\Auth\GoogleController;

// Taruh berdiri sendiri di luar blok auth
Route::post('/login-google', [GoogleController::class, 'handleCallback']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    // Atau bisa juga di dalam sini
});

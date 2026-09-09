<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\BookingController;

// Halaman Beranda (List Film)
Route::get('/index', [MovieController::class, 'index'])->name('movies.index');

// Halaman Detail Film
Route::get('/movie/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Halaman Pilih Kursi
Route::get('/booking/seats/{showtime}', [BookingController::class, 'seats'])->name('booking.seats');

// Simpan Pemesanan
Route::post('/booking/store/{showtime}', [BookingController::class, 'store'])->name('booking.store');

// Halaman E-Tiket
Route::get('/booking/ticket/{booking}', [BookingController::class, 'ticket'])->name('booking.ticket');

Route::get('/', function () {
    return view('movies.index');
});
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    /**
     * Tampilkan semua film (dipanggil dari tombol "Semua").
     */
    public function all()
    {
        $movies = Movie::orderBy('title')->get();

        return view('movies.semua', compact('movies'));
    }

    /**
     * Halaman daftar bioskop.
     */
    public function bioskop()
    {
        $cinemas = Cinema::orderBy('name')->get();

        return view('cinemas.index', compact('cinemas'));
    }

    /**
     * Halaman "Tiket Saya" — riwayat pemesanan milik user yang sedang login.
     */
    public function tiket()
    {
        $bookings = Booking::with('showtime.movie', 'showtime.cinema')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('tickets.index', compact('bookings'));
    }
}

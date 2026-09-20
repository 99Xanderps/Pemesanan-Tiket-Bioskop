<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    // Menampilkan daftar film yang SEDANG TAYANG (halaman utama), bisa difilter berdasarkan jaringan bioskop
    public function index(Request $request)
    {
        $chain = $request->query('chain'); // contoh: XXI, CGV, Cinepolis, FLIX

        // Hanya film yang punya minimal 1 jadwal tayang yang dianggap "Sedang Tayang".
        // Film tanpa jadwal otomatis dianggap "Akan Tayang" (ditangani terpisah di view).
        $query = Movie::whereHas('showtimes')->latest();

        if ($chain && $chain !== 'Semua Film') {
            $query->whereHas('showtimes.cinema', function ($q) use ($chain) {
                $q->where('name', 'like', '%' . $chain . '%');
            });
        }

        $movies = $query->get();

        return view('movies.index', [
            'movies' => $movies,
            'activeChain' => $chain ?? 'Semua Film',
        ]);
    }

    // Menampilkan detail film + daftar jadwal tayangnya
    public function show(Movie $movie)
    {
        $movie->load(['showtimes' => function ($query) {
            $query->where('show_date', '>=', now()->toDateString())
                  ->orderBy('show_date')
                  ->orderBy('show_time')
                  ->with('cinema');
        }]);

        return view('movies.show', compact('movie'));
    }
}

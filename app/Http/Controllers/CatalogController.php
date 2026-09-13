<?php

namespace App\Http\Controllers;

use App\Models\Movie;

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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MoviePosterController extends Controller
{
    /**
     * Halaman daftar film + form upload poster.
     */
    public function index()
    {
        $movies = Movie::orderBy('title')->get();

        return view('admin.movies', compact('movies'));
    }

    /**
     * Proses upload/ganti poster untuk 1 film.
     */
    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'poster' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // maks 2MB
        ], [
            'poster.image' => 'File yang diupload harus berupa gambar.',
            'poster.mimes' => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'poster.max'   => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Kalau poster lama itu file lokal (bukan link luar), hapus dulu supaya tidak numpuk sampah.
        if ($movie->poster && str_starts_with($movie->poster, '/storage/posters/')) {
            $oldPath = str_replace('/storage/', '', $movie->poster);
            Storage::disk('public')->delete($oldPath);
        }

        // Simpan file baru ke storage/app/public/posters
        $path = $request->file('poster')->store('posters', 'public');

        $movie->update([
            'poster' => '/storage/' . $path,
        ]);

        return back()->with('success', 'Poster "' . $movie->title . '" berhasil diperbarui.');
    }
}

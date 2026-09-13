<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Database\Seeder;

class BioskopSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Bioskop ----------
        $cinema1 = Cinema::create(['name' => 'XXI BG Junction',     'city' => 'Surabaya', 'studio' => 'Studio 1']);
        $cinema2 = Cinema::create(['name' => 'CGV Ciputra World',   'city' => 'Surabaya', 'studio' => 'Studio Premiere']);
        $cinema3 = Cinema::create(['name' => 'Cinepolis Marvell City', 'city' => 'Surabaya', 'studio' => 'Studio VIP']);
        $cinema4 = Cinema::create(['name' => 'FLIX Grand City',     'city' => 'Surabaya', 'studio' => 'Studio 3']);

        // ---------- Film yang SEDANG TAYANG (punya jadwal) ----------
        $movie1 = Movie::create([
            'title'    => 'Munafik',
            'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Munafik',
            'genre'    => 'Horror',
            'duration' => 110,
            'synopsis' => 'Seorang ayah harus menghadapi teror gaib demi menyelamatkan anaknya.',
            'rating'   => 'D17',
        ]);

        $movie2 = Movie::create([
            'title'    => 'Memburu Pemangsa',
            'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Memburu+Pemangsa',
            'genre'    => 'Horror-Crime-Action',
            'duration' => 105,
            'synopsis' => 'Kisah perburuan penuh ketegangan melawan sosok pemangsa yang mengerikan.',
            'rating'   => 'D17',
        ]);

        foreach ([$movie1, $movie2] as $movie) {
            foreach ([$cinema1, $cinema2, $cinema3, $cinema4] as $cinema) {
                Showtime::create([
                    'movie_id'  => $movie->id,
                    'cinema_id' => $cinema->id,
                    'show_date' => now()->toDateString(),
                    'show_time' => '19:00:00',
                    'price'     => 35000,
                ]);
                Showtime::create([
                    'movie_id'  => $movie->id,
                    'cinema_id' => $cinema->id,
                    'show_date' => now()->addDay()->toDateString(),
                    'show_time' => '21:00:00',
                    'price'     => 40000,
                ]);
            }
        }

        // ---------- Film yang AKAN TAYANG (sengaja belum punya jadwal) ----------
        Movie::create([
            'title'    => 'Gelombang Cherry',
            'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Gelombang+Cherry',
            'genre'    => 'Drama, Musikal',
            'duration' => 110,
            'synopsis' => 'Seorang musisi jalanan berjuang meraih mimpinya di tengah gemerlap kota pesisir.',
            'rating'   => 'R13',
        ]);

        Movie::create([
            'title'    => 'Musim',
            'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Musim',
            'genre'    => 'Drama, Keluarga',
            'duration' => 102,
            'synopsis' => 'Empat cerita dari empat musim berbeda dalam kehidupan satu keluarga besar.',
            'rating'   => 'SU',
        ]);
    }
}

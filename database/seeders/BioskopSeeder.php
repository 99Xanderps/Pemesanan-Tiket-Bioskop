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
        $cinema1 = Cinema::create(['name' => 'XXI BG Junction', 'city' => 'Surabaya', 'studio' => 'Studio 1']);
        $cinema2 = Cinema::create(['name' => 'CGV Ciputra World', 'city' => 'Surabaya', 'studio' => 'Studio Premiere']);

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
            foreach ([$cinema1, $cinema2] as $cinema) {
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
    }
}
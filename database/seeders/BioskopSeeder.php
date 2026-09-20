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
        $cinemas = collect([
            Cinema::create(['name' => 'XXI BG Junction',        'city' => 'Surabaya', 'studio' => 'Studio 1']),
            Cinema::create(['name' => 'CGV Ciputra World',      'city' => 'Surabaya', 'studio' => 'Studio Premiere']),
            Cinema::create(['name' => 'Cinepolis Marvell City', 'city' => 'Surabaya', 'studio' => 'Studio VIP']),
            Cinema::create(['name' => 'FLIX Grand City',        'city' => 'Surabaya', 'studio' => 'Studio 3']),
        ]);

        // ---------- Semua Film ----------
        $movies = collect([
            Movie::create([
                'title'    => 'Mr. Rey',
                'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Mr.+Rey',
                'genre'    => 'Adventure',
                'duration' => 110,
                'synopsis' => 'Cerita dan perjalanan dari mr rey.',
                'rating'   => 'R13',
            ]),
            Movie::create([
                'title'    => 'Pencuri Uang',
                'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Pencuri+Uang',
                'genre'    => 'Crime',
                'duration' => 105,
                'synopsis' => 'Kisah tentang dua aksi pencuriang uang terbesar di spanyol.',
                'rating'   => 'D17',
            ]),
            Movie::create([
                'title'    => 'Sleepy Boys',
                'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Sleepy+Boys',
                'genre'    => 'Drama',
                'duration' => 110,
                'synopsis' => 'Seorang pelajar yang tertidur di kelas karena habis begadang koding semalaman.',
                'rating'   => 'R13',
            ]),
            Movie::create([
                'title'    => '500 Hari Di Musim Panas',
                'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Musim+Panas',
                'genre'    => 'Romance',
                'duration' => 102,
                'synopsis' => '500 hari buat buang buang waktu mending tidur.',
                'rating'   => 'SU',
            ]),
        ]);

        // ---------- Jadwal tayang: real-time, dihitung dari tanggal & jam SEKARANG ----------
        // Supaya jadwalnya selalu relevan (tidak ada jadwal yang "sudah lewat" hari ini),
        // jam tayang dihasilkan mulai dari sekarang + 1 jam, lalu diulang tiap 2.5 jam, untuk 3 hari ke depan.
        $now = now();

        foreach ($movies as $movie) {
            foreach ($cinemas as $cinema) {
                for ($day = 0; $day < 3; $day++) {
                    // 4 slot jadwal per hari per bioskop
                    for ($slot = 0; $slot < 4; $slot++) {
                        $waktu = $now->copy()
                            ->addDay($day)
                            ->setTime(13, 0)
                            ->addMinutes($slot * 150); // 13:00, 15:30, 18:00, 20:30

                        // Kalau jadwal hari ini sudah lewat dari jam sekarang, skip (jangan bikin jadwal masa lalu)
                        if ($day === 0 && $waktu->lessThan($now)) {
                            continue;
                        }

                        Showtime::create([
                            'movie_id'  => $movie->id,
                            'cinema_id' => $cinema->id,
                            'show_date' => $waktu->toDateString(),
                            'show_time' => $waktu->format('H:i:s'),
                            'price'     => 35000 + ($slot * 5000), // makin malam, makin mahal dikit
                        ]);
                    }
                }
            }
        }
        // ---------- Film yang AKAN TAYANG (JANGAN taruh di $movies atas — sengaja tanpa jadwal) ----------
        Movie::create([
            'title'    => 'Manusia Setengah Raja Iblis',
            'poster'   => 'https://placehold.co/300x450/1a0000/ffffff?text=Manusia+Setengah+Raja+Iblis',
            'genre'    => 'Fantasy, Komedi',
            'duration' => 105,
            'synopsis' => 'Seorang manusia setengah raja iblis merasa bahwa dunia  hanyalah alat.',
            'rating'   => 'SU',
        ]);
    }
}

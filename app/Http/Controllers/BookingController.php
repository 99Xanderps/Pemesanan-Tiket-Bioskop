<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // STEP 1: Tampilkan denah kursi untuk sebuah jadwal tayang
    public function seats(Showtime $showtime)
    {
        $showtime->load('movie', 'cinema');

        // Jika kursi belum pernah dibuat untuk showtime ini, generate otomatis (5 baris x 8 kolom)
        if ($showtime->seats()->count() === 0) {
            $rows = ['A', 'B', 'C', 'D', 'E'];
            foreach ($rows as $row) {
                for ($i = 1; $i <= 8; $i++) {
                    Seat::create([
                        'showtime_id' => $showtime->id,
                        'seat_code'   => $row . $i,
                    ]);
                }
            }
        }

        $seats = $showtime->seats()->orderBy('seat_code')->get();

        return view('booking.seats', compact('showtime', 'seats'));
    }

    // STEP 2: Simpan pilihan kursi & data pemesan, buat booking baru
    public function store(Request $request, Showtime $showtime)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email',
            'seats'          => 'required|array|min:1',
            'seats.*'        => 'exists:seats,id',
        ]);

        $seats = Seat::whereIn('id', $validated['seats'])
            ->where('showtime_id', $showtime->id)
            ->where('is_booked', false)
            ->get();

        if ($seats->count() !== count($validated['seats'])) {
            return back()->withErrors('Beberapa kursi yang dipilih sudah tidak tersedia. Silakan pilih ulang.');
        }

        $totalPrice = $showtime->price * $seats->count();

        $booking = Booking::create([
            'showtime_id'    => $showtime->id,
            'customer_name'  => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'total_price'    => $totalPrice,
            'booking_code'   => strtoupper(Str::random(8)),
            'status'         => 'pending',
        ]);

        $booking->seats()->attach($seats->pluck('id'));
        $seats->each->update(['is_booked' => true]);

        return redirect()->route('booking.confirm', $booking)
            ->with('success', 'Pemesanan berhasil dibuat!');
    }

    // STEP 3: Halaman konfirmasi/e-ticket
    public function confirm(Booking $booking)
    {
        $booking->load('showtime.movie', 'showtime.cinema', 'seats');
        return view('booking.confirm', compact('booking'));
    }
}

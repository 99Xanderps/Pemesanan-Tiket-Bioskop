<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Baris kursi default kalau showtime belum pernah dibuatkan kursi.
     */
    private array $rows = ['A', 'B', 'C', 'D', 'E'];
    private int $seatsPerRow = 8;

    /**
     * Halaman pilih kursi.
     */
    public function seats(Showtime $showtime)
    {
        $showtime->load('movie', 'cinema');

        // Kalau showtime ini belum punya data kursi sama sekali, buatkan otomatis.
        if ($showtime->seats()->count() === 0) {
            foreach ($this->rows as $row) {
                for ($n = 1; $n <= $this->seatsPerRow; $n++) {
                    Seat::create([
                        'showtime_id' => $showtime->id,
                        'seat_code'   => $row . $n,
                        'is_booked'   => false,
                    ]);
                }
            }
        }

        $seats = $showtime->seats()->orderBy('seat_code')->get()->groupBy(function ($seat) {
            return substr($seat->seat_code, 0, 1); // kelompokkan per baris (A, B, C, ...)
        });

        return view('booking.seats', compact('showtime', 'seats'));
    }

    /**
     * Simpan pemesanan dari kursi yang dipilih.
     */
    public function store(Request $request, Showtime $showtime)
    {
        $validated = $request->validate([
            'seat_ids'       => ['required', 'array', 'min:1'],
            'seat_ids.*'     => ['integer', 'exists:seats,id'],
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
        ]);

        // Ambil kursi yang benar-benar milik showtime ini dan belum dibooking siapapun.
        $seats = Seat::whereIn('id', $validated['seat_ids'])
            ->where('showtime_id', $showtime->id)
            ->where('is_booked', false)
            ->get();

        if ($seats->count() !== count($validated['seat_ids'])) {
            return back()
                ->withErrors(['seat_ids' => 'Salah satu kursi yang kamu pilih ternyata sudah dibooking orang lain. Silakan pilih ulang.'])
                ->withInput();
        }

        $totalPrice = $seats->count() * $showtime->price;

        $booking = Booking::create([
            'user_id'         => Auth::id(),
            'showtime_id'     => $showtime->id,
            'customer_name'   => $validated['customer_name'],
            'customer_email'  => $validated['customer_email'],
            'total_price'     => $totalPrice,
            'booking_code'    => 'TKT-' . strtoupper(Str::random(8)),
            'status'          => 'pending',
        ]);

        $booking->seats()->attach($seats->pluck('id'));

        // Tandai kursi sebagai sudah dibooking (belum tentu dibayar, tapi supaya tidak direbut orang lain)
        Seat::whereIn('id', $seats->pluck('id'))->update(['is_booked' => true]);

        return redirect()->route('booking.pay', $booking);
    }

    /**
     * Halaman pembayaran (dummy/simulasi).
     */
    public function pay(Booking $booking)
    {
        $this->authorizeOwner($booking);

        if ($booking->status !== 'pending') {
            return redirect()->route('booking.ticket', $booking);
        }

        $booking->load('showtime.movie', 'showtime.cinema', 'seats');

        return view('booking.pay', compact('booking'));
    }

    /**
     * Proses konfirmasi pembayaran (simulasi — tidak benar-benar mengirim ke payment gateway).
     */
    public function confirmPay(Request $request, Booking $booking)
    {
        $this->authorizeOwner($booking);

        $request->validate([
            'metode' => ['required', 'in:transfer_bca,transfer_mandiri,ovo,gopay'],
        ]);

        if ($booking->status === 'pending') {
            $booking->update(['status' => 'paid']);
        }

        return redirect()->route('booking.ticket', $booking)
            ->with('success', 'Pembayaran berhasil! Tiketmu sudah siap.');
    }

    /**
     * Halaman e-tiket.
     */
    public function ticket(Booking $booking)
    {
        $this->authorizeOwner($booking);

        $booking->load('showtime.movie', 'showtime.cinema', 'seats');

        return view('booking.ticket', compact('booking'));
    }

    /**
     * Pastikan booking ini memang milik user yang sedang login.
     */
    private function authorizeOwner(Booking $booking): void
    {
        abort_unless($booking->user_id === Auth::id(), 403, 'Tiket ini bukan milikmu.');
    }
}

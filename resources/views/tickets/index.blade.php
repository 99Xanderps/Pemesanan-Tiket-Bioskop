@extends('layouts.app')

@section('title', 'Tiket Saya - Bioskopku')

@section('content')

    <div class="section">
        <div class="section-head">
            <h4>Tiket Saya</h4>
        </div>

        @forelse ($bookings as $booking)
            <a href="{{ route('booking.ticket', $booking) }}" class="panel" style="display:block; margin-bottom:12px; text-decoration:none; color:inherit;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <div style="font-weight:700; font-size:15px;">{{ $booking->showtime->movie->title }}</div>
                        <div class="section-sub" style="margin:2px 0 6px;">
                            {{ $booking->showtime->cinema->name }} &middot;
                            {{ \Illuminate\Support\Carbon::parse($booking->showtime->show_date)->translatedFormat('d M Y') }},
                            {{ \Illuminate\Support\Carbon::parse($booking->showtime->show_time)->format('H:i') }}
                        </div>
                        <div class="section-sub">Kode: {{ $booking->booking_code }}</div>
                    </div>
                    @if ($booking->status === 'paid')
                        <span class="badge-rating" style="background-color:#2ea043;">Sudah Dibayar</span>
                    @elseif ($booking->status === 'pending')
                        <span class="badge-rating" style="background-color:#a3050d;">Belum Bayar</span>
                    @else
                        <span class="badge-rating" style="background-color:#4a4a4a;">Dibatalkan</span>
                    @endif
                </div>
            </a>
        @empty
            <p class="section-sub">Kamu belum punya tiket. Yuk pesan film favoritmu!</p>
            <a href="{{ route('movies.index') }}" class="btn-merah" style="display:inline-block; margin-top:8px; text-decoration:none;">Cari Film</a>
        @endforelse
    </div>

@endsection

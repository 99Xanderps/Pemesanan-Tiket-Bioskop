@extends('layouts.app')

@section('title', 'E-Tiket - Bioskopku')

@section('content')

    <div class="section" style="padding-top:16px;">

        <div class="panel" style="border: 2px dashed var(--merah);">
            <div style="text-align:center; margin-bottom:12px;">
                <div style="font-size:22px;">🎟️</div>
                <h4 style="color: var(--merah); margin:4px 0;">E-TIKET</h4>
                <p class="section-sub" style="margin:0;">Kode Booking</p>
                <h2 style="margin:2px 0;">{{ $booking->booking_code }}</h2>
            </div>

            <div style="border-top:1px solid #2a2a2a; margin:14px 0;"></div>

            <p style="margin:6px 0;"><strong>Film:</strong> {{ $booking->showtime->movie->title }}</p>
            <p style="margin:6px 0;"><strong>Bioskop:</strong> {{ $booking->showtime->cinema->name }} ({{ $booking->showtime->cinema->studio }})</p>
            <p style="margin:6px 0;"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->showtime->show_date)->translatedFormat('d M Y') }}</p>
            <p style="margin:6px 0;"><strong>Jam:</strong> {{ \Carbon\Carbon::parse($booking->showtime->show_time)->format('H:i') }}</p>
            <p style="margin:6px 0;"><strong>Kursi:</strong> {{ $booking->seats->pluck('seat_code')->join(', ') }}</p>
            <p style="margin:6px 0;"><strong>Atas Nama:</strong> {{ $booking->customer_name }}</p>
            <p style="margin:6px 0;"><strong>Email:</strong> {{ $booking->customer_email }}</p>

            <div style="border-top:1px solid #2a2a2a; margin:14px 0;"></div>

            <div style="display:flex; justify-content:space-between;">
                <strong>Total Bayar</strong>
                <strong style="color: var(--merah);">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</strong>
            </div>

            <div style="text-align:center; margin-top:16px;">
                <span class="badge-rating" style="background-color:#8a6d00;">Status: {{ ucfirst($booking->status) }}</span>
            </div>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <a href="{{ route('movies.index') }}" class="btn-merah" style="display:inline-block;">Pesan Tiket Lainnya</a>
        </div>
    </div>

@endsection
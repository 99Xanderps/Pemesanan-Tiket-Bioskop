@extends('layouts.app')

@section('title', 'E-Tiket - Bioskopku')

@section('content')

    <div class="section">
        <div class="section-head">
            <h4>E-Tiket</h4>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="panel" style="text-align:center; padding:24px 18px;">
            @if ($booking->status === 'paid')
                <span class="badge-rating" style="background-color:#2ea043;">Sudah Dibayar</span>
            @else
                <span class="badge-rating" style="background-color:#a3050d;">Belum Dibayar</span>
            @endif

            <h3 style="margin:14px 0 4px; font-size:20px;">{{ $booking->showtime->movie->title }}</h3>
            <p class="section-sub" style="margin:0 0 18px;">{{ $booking->showtime->movie->genre }}</p>

            <div style="border-top:1px dashed #333; border-bottom:1px dashed #333; padding:16px 0; margin-bottom:16px; text-align:left;">
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <span class="section-sub">Bioskop</span>
                    <span>{{ $booking->showtime->cinema->name }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <span class="section-sub">Studio</span>
                    <span>{{ $booking->showtime->cinema->studio }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <span class="section-sub">Tanggal</span>
                    <span>{{ \Illuminate\Support\Carbon::parse($booking->showtime->show_date)->translatedFormat('d M Y') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <span class="section-sub">Jam</span>
                    <span>{{ \Illuminate\Support\Carbon::parse($booking->showtime->show_time)->format('H:i') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; margin-bottom:8px;">
                    <span class="section-sub">Kursi</span>
                    <span>{{ $booking->seats->pluck('seat_code')->join(', ') }}</span>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span class="section-sub">Atas Nama</span>
                    <span>{{ $booking->customer_name }}</span>
                </div>
            </div>

            <div style="font-family:monospace; font-size:20px; letter-spacing:3px; color:var(--merah); font-weight:700; margin-bottom:6px;">
                {{ $booking->booking_code }}
            </div>
            <p class="section-sub">Tunjukkan kode ini di loket bioskop</p>
        </div>

        <a href="{{ route('tickets.mine') }}" class="btn-merah" style="display:block; text-align:center; margin-top:16px; text-decoration:none;">
            Lihat Semua Tiket Saya
        </a>
    </div>

@endsection

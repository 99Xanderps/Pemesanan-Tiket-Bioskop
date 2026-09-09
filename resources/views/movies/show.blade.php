@extends('layouts.app')

@section('title', $movie->title . ' - Bioskopku')

@section('content')

    <div class="section" style="padding-top:16px;">
        <div class="poster-wrap" style="margin-bottom:14px;">
            <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" style="width:100%; height:320px; object-fit:cover; border-radius: var(--radius);">
            <span class="rating-tag">{{ $movie->rating }}</span>
        </div>

        <h2 style="color: var(--merah); margin: 0 0 4px; font-size:22px;">{{ $movie->title }}</h2>
        <p class="section-sub" style="margin-bottom:12px;">{{ $movie->genre }} &middot; {{ $movie->duration }} menit</p>
        <p style="line-height:1.5; color:#dcdcdc;">{{ $movie->synopsis }}</p>

        <div style="border-top:1px solid #222; margin: 18px 0;"></div>

        <h4 style="margin-bottom:12px;">Pilih Jadwal Tayang</h4>

        @forelse ($movie->showtimes->groupBy('cinema.name') as $cinemaName => $showtimes)
            <div class="panel" style="margin-bottom:12px;">
                <strong>{{ $cinemaName }}</strong>
                <div style="margin-top:10px;">
                    @foreach ($showtimes as $showtime)
                        <a href="{{ route('booking.seats', $showtime) }}" class="showtime-btn">
                            {{ \Carbon\Carbon::parse($showtime->show_date)->translatedFormat('d M') }}
                            &middot;
                            {{ \Carbon\Carbon::parse($showtime->show_time)->format('H:i') }}
                            &middot;
                            Rp{{ number_format($showtime->price, 0, ',', '.') }}
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="section-sub">Belum ada jadwal untuk film ini.</p>
        @endforelse
    </div>

@endsection
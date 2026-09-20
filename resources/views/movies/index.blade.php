@extends('layouts.app')

@section('title', 'Sedang Tayang - Bioskopku')

@section('content')

    {{-- PROMO BANNER (informatif, sengaja tidak bisa diklik) --}}
    <div class="promo-banner">
        <div class="promo-eyebrow">PROMO HARI INI</div>
        <h3>Nonton hemat, cukup Rp25rb</h3>
        <p>Kursi terbaik cepat habis. Amankan tempat dudukmu sebelum kehabisan.</p>
        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:14px;">
            <span style="background-color:rgba(255,255,255,0.12); color:#ffd9dc; font-size:11.5px; font-weight:600; padding:6px 12px; border-radius:999px;">
                ✓ Semua film 2D &amp; 3D
            </span>
            <span style="background-color:rgba(255,255,255,0.12); color:#ffd9dc; font-size:11.5px; font-weight:600; padding:6px 12px; border-radius:999px;">
                ✓ Tanpa antre loket
            </span>
            <span style="background-color:rgba(255,255,255,0.12); color:#ffd9dc; font-size:11.5px; font-weight:600; padding:6px 12px; border-radius:999px;">
                ✓ E-tiket langsung jadi
            </span>
        </div>
    </div>

    {{-- SEDANG TAYANG --}}
    <div class="section">
        <div class="section-head">
            <h4>Sedang Tayang</h4>
            <a href="{{ route('movies.all') }}" class="see-all">
                Semua
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 6 15 12 9 18"/>
                </svg>
            </a>
        </div>

        <div class="pill-row">
            @foreach (['Semua Film', 'XXI', 'CGV', 'Cinepolis', 'FLIX'] as $chain)
             <a href="{{ route('movies.index', $chain === 'Semua Film' ? [] : ['chain' => $chain]) }}"
                class="pill {{ (request('chain', 'Semua Film') === $chain) ? 'active' : '' }}">
                {{ $chain }}
             </a>
             @endforeach
        </div>

        <div class="movie-scroller">
            @forelse ($movies as $movie)
                <a href="{{ route('movies.show', $movie) }}" class="movie-card">
                    <div class="poster-wrap">
                        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                        <span class="rating-tag">{{ $movie->rating }}</span>
                    </div>
                    <div class="title">{{ $movie->title }}</div>
                    <div class="meta">{{ $movie->genre }} &middot; {{ $movie->duration }} mnt</div>
                </a>
            @empty
                <p class="section-sub">Belum ada film untuk filter ini.</p>
            @endforelse
        </div>
    </div>

    {{-- AKAN TAYANG --}}
    @php
        // Film yang belum punya jadwal tayang sama sekali dianggap "Akan Tayang".
        // Jadi cukup tambah film baru di tabel movies (tanpa showtime), otomatis muncul di sini.
        $comingSoon = \App\Models\Movie::doesntHave('showtimes')->latest()->get();
    @endphp

    <div class="section">
        <div class="section-head">
            <h4>Akan Tayang</h4>
            <a href="{{ route('movies.all') }}" class="see-all">
                Semua
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="9 6 15 12 9 18"/>
                </svg>
            </a>
        </div>
        <p class="section-sub">Film-film seru yang segera tayang di bioskop</p>

        <div class="movie-scroller">
            @forelse ($comingSoon as $movie)
                <a href="{{ route('movies.show', $movie) }}" class="movie-card">
                    <div class="poster-wrap">
                        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}">
                        <span class="partner-tag">TIX PARTNER</span>
                    </div>
                    <div class="title">{{ $movie->title }}</div>
                    <div class="meta">{{ $movie->genre }}</div>
                </a>
            @empty
                <p class="section-sub">Belum ada film yang akan tayang.</p>
            @endforelse
        </div>
    </div>

@endsection

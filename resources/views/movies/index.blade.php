@extends('layouts.app')

@section('title', 'Sedang Tayang - Bioskopku')

@section('content')

    {{-- PROMO BANNER --}}
    <div class="promo-banner">
        <div class="promo-eyebrow">PROMO HARI INI</div>
        <h3>Nonton hemat, cukup Rp25rb</h3>
        <p>Berlaku untuk kelas Reguler, semua film 2D &amp; 3D, khusus hari ini.</p>
        <a href="#" class="promo-cta">Beli di Sini</a>
    </div>

    {{-- SEDANG TAYANG --}}
    <div class="section">
        <div class="section-head">
            <h4>🎬 Sedang Tayang</h4>
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
        // Sementara diambil langsung di sini berdasarkan judul.
        // Idealnya nanti dipindah ke MovieController dan dikirim sebagai variabel terpisah,
        // misalnya $comingSoon, supaya query tidak nangkring di view.
        $comingSoon = \App\Models\Movie::whereIn('title', ['Gelombang Cherry', 'Musim'])->get();
    @endphp

    <div class="section">
        <div class="section-head">
            <h4>⏳ Akan Tayang</h4>
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

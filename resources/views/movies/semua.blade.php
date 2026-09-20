@extends('layouts.app')

@section('title', 'Semua Film - Bioskopku')

@section('content')

    <div class="section">
        <div class="section-head">
            <h4>Semua Film</h4>
        </div>
        <p class="section-sub">{{ $movies->count() }} film tersedia</p>

        <div class="movie-grid">
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
                <p class="section-sub">Belum ada film sama sekali.</p>
            @endforelse
        </div>
    </div>

@endsection

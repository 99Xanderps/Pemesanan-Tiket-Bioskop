@extends('layouts.app')

@section('title', 'Bioskop - Bioskopku')

@section('content')

    <div class="section">
        <div class="section-head">
            <h4>Daftar Bioskop</h4>
        </div>
        <p class="section-sub">{{ $cinemas->count() }} bioskop di Surabaya</p>

        @forelse ($cinemas as $cinema)
            <div class="panel" style="margin-bottom: 12px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <div style="font-weight:700; font-size:15px;">{{ $cinema->name }}</div>
                        <div class="section-sub" style="margin:2px 0 0;">{{ $cinema->city }} &middot; {{ $cinema->studio }}</div>
                    </div>
                    <a href="{{ route('movies.all') }}" class="see-all" style="text-decoration:none;">Lihat Film</a>
                </div>
            </div>
        @empty
            <p class="section-sub">Belum ada bioskop terdaftar.</p>
        @endforelse
    </div>

@endsection

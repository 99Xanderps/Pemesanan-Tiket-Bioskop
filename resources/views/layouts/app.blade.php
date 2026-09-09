<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bioskopku')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
</head>
<body>

<div class="app-frame">

    {{-- TOP BAR --}}
    <div class="topbar">
        <div class="search-box">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <span>Cari film, bioskop...</span>
        </div>
        <div class="icon-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 18v-6a9 9 0 0 1 18 0v6"/>
                <path d="M21 19a2 2 0 0 1-2 2h-1v-8h3z"/>
                <path d="M3 19a2 2 0 0 0 2 2h1v-8H3z"/>
            </svg>
        </div>
        <div class="icon-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
            </svg>
        </div>
    </div>

    {{-- LOCATION BAR --}}
    <div class="location-bar">
        <div class="loc-label">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/>
            </svg>
            SURABAYA
        </div>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 12 15 18 9"/>
        </svg>
    </div>

    {{-- FLASH MESSAGES --}}
    @if (session('success'))
        <div class="alert alert-success" style="margin-top:16px;">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-top:16px;">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- KONTEN HALAMAN --}}
    @yield('content')

    {{-- BOTTOM NAV --}}
    <div class="bottom-nav">
        <a href="{{ route('movies.index') }}" class="nav-item {{ request()->routeIs('movies.index') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 11l9-8 9 8"/><path d="M5 10v10h14V10"/>
            </svg>
            Beranda
        </a>
        <a href="#" class="nav-item {{ request()->routeIs('movies.show') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18"/><path d="M9 4v5"/>
            </svg>
            Bioskop
        </a>
        <a href="#" class="nav-item {{ request()->routeIs('booking.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4z"/>
            </svg>
            Tiket
        </a>
    </div>

</div>

@yield('scripts')
</body>
</html>
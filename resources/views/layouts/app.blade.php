<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bioskopku')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>
<body>

<div class="app-frame">

    {{-- TOP BAR --}}
    <div class="topbar">
        <a href="{{ route('movies.index') }}" style="flex:1; display:flex; align-items:center; gap:8px; text-decoration:none; color:var(--putih);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--merah)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="6" width="20" height="13" rx="2"/>
                <path d="M2 10h20"/><path d="M7 6L5 3"/><path d="M12 6l-2-3"/><path d="M17 6l-2-3"/>
            </svg>
            <span style="font-size:19px; font-weight:800; letter-spacing:-0.3px;">
                Bioskop<span style="color:var(--merah);">Ku</span>
            </span>
        </a>
        @auth
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="icon-btn"
               title="Login sebagai {{ auth()->user()->name }} — klik untuk logout"
               style="background-color: var(--merah); border-color: var(--merah); color: var(--putih); font-weight: 800; font-size: 14px; position: relative;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                <span style="position:absolute; bottom:-1px; right:-1px; width:10px; height:10px; border-radius:50%; background-color:#2ea043; border:2px solid var(--hitam);"></span>
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}" class="icon-btn" title="Belum login — klik untuk masuk">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
                </svg>
            </a>
        @endauth
    </div>

    {{-- LOCATION BAR --}}
    <div class="location-bar">
        <div class="loc-label">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z"/>
            </svg>
            SURABAYA
        </div>
        <span style="font-size:11.5px; color:var(--abu); font-weight:600; letter-spacing:0.3px;">
            4 BIOSKOP TERSEDIA
        </span>
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
        <a href="{{ route('cinemas.index') }}" class="nav-item {{ request()->routeIs('cinemas.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18"/><path d="M9 4v5"/>
            </svg>
            Bioskop
        </a>
        <a href="{{ auth()->check() ? route('tickets.mine') : route('login') }}" class="nav-item {{ request()->routeIs('tickets.*') || request()->routeIs('booking.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 0 0-4z"/>
            </svg>
            Tiket
        </a>
    </div>

</div>

@yield('scripts')

<script>
// Supaya .movie-scroller bisa di-drag pakai mouse di desktop
// (di HP asli tetap bisa swipe normal tanpa script ini)
document.querySelectorAll('.movie-scroller').forEach(function (scroller) {
    let isDown = false;
    let startX;
    let scrollLeft;

    scroller.addEventListener('mousedown', function (e) {
        isDown = true;
        scroller.classList.add('dragging');
        startX = e.pageX - scroller.offsetLeft;
        scrollLeft = scroller.scrollLeft;
    });

    ['mouseleave', 'mouseup'].forEach(function (evt) {
        scroller.addEventListener(evt, function () {
            isDown = false;
            scroller.classList.remove('dragging');
        });
    });

    scroller.addEventListener('mousemove', function (e) {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - scroller.offsetLeft;
        const walk = (x - startX) * 1.5;
        scroller.scrollLeft = scrollLeft - walk;
    });
});
</script>
</body>
</html>

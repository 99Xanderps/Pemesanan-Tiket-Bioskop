<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Bioskopku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="app-frame">
        <div class="topbar">
            <div style="flex:1; font-size:18px; font-weight:800;">
                Bioskop<span style="color:var(--merah);">Ku</span> <span class="section-sub" style="font-size:12px; font-weight:600;">Admin</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="icon-btn" style="border:none;" title="Logout">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
        </div>

        <div class="section">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <p class="section-sub" style="margin-bottom:14px;">Halo, {{ auth()->user()->name }}     </p>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:20px;">
                <div class="panel">
                    <div class="section-sub">Total Film</div>
                    <div style="font-size:22px; font-weight:800;">{{ $stats['totalMovies'] }}</div>
                </div>
                <div class="panel">
                    <div class="section-sub">Total Bioskop</div>
                    <div style="font-size:22px; font-weight:800;">{{ $stats['totalCinemas'] }}</div>
                </div>
                <div class="panel">
                    <div class="section-sub">Total User</div>
                    <div style="font-size:22px; font-weight:800;">{{ $stats['totalUsers'] }}</div>
                </div>
                <div class="panel">
                    <div class="section-sub">Tiket Terjual</div>
                    <div style="font-size:22px; font-weight:800;">{{ $stats['totalPaid'] }}</div>
                </div>
            </div>

            <div class="panel" style="margin-bottom:20px;">
                <div class="section-sub">Total Pendapatan (tiket sudah dibayar)</div>
                <div style="font-size:24px; font-weight:800; color:var(--merah);">
                    Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}
                </div>
                <div class="section-sub" style="margin-top:4px;">
                    dari {{ $stats['totalBookings'] }} total pesanan ({{ $stats['totalPaid'] }} sudah dibayar)
                </div>
            </div>

            <div class="section-head">
                <h4>Menu</h4>
            </div>
            <a href="{{ route('admin.movies.index') }}" class="panel" style="display:block; text-decoration:none; color:inherit; margin-bottom:10px;">
                Kelola Poster Film
            </a>
            <a href="{{ route('movies.index') }}" class="panel" style="display:block; text-decoration:none; color:inherit;">
                Lihat Website
            </a>
        </div>
    </div>
</body>
</html>

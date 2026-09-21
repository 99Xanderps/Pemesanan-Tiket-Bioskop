<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bioskopku')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/css/auth.css')
</head>
<body>
    <div class="phone-frame">
        <header class="app-header">
            <button type="button" class="icon-btn" onclick="history.back()" aria-label="Kembali">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <span class="app-header-title">Bioskop<span>ku</span></span>
            <span class="icon-btn-spacer"></span>
        </header>

        <main class="auth-body">
            @yield('content')
        </main>
    </div>
</body>
</html>

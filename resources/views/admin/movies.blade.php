<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Poster Film - Bioskopku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="app-frame">
        <div class="topbar">
            <a href="{{ route('admin.dashboard') }}" class="icon-btn" title="Kembali ke dashboard">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 18l-6-6 6-6"/>
                </svg>
            </a>
            <div style="flex:1; font-weight:700; padding-left:8px;">Kelola Poster Film</div>
        </div>

        <div class="section">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @foreach ($movies as $movie)
                <div class="panel" style="margin-bottom:14px;">
                    <div style="display:flex; gap:14px;">
                        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}"
                             style="width:70px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #2a2a2a; flex-shrink:0;">

                        <div style="flex:1;">
                            <div style="font-weight:700; margin-bottom:8px;">{{ $movie->title }}</div>

                            <form method="POST" action="{{ route('admin.movies.updatePoster', $movie) }}" enctype="multipart/form-data">
                                @csrf

                                <input type="file" name="poster" accept="image/png, image/jpeg, image/webp" required
                                       style="font-size:12.5px; color:var(--abu); margin-bottom:8px; display:block;">

                                <button type="submit" class="btn-merah" style="font-size:12.5px; padding:7px 14px;">
                                    Upload Poster Baru
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>

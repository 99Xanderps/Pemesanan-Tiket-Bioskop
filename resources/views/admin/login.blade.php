<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Bioskopku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="app-frame" style="display:flex; align-items:center; justify-content:center; padding:24px;">
        <div class="panel" style="width:100%; max-width:340px;">
            <div style="text-align:center; margin-bottom:20px;">
                <div style="font-size:20px; font-weight:800;">Bioskop<span style="color:var(--merah);">Ku</span></div>
                <div class="section-sub" style="margin-top:4px;">Panel Admin</div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger" style="margin:0 0 14px;">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="field" style="margin-bottom:12px;">
                    <label for="email" style="display:block; font-size:13px; color:var(--abu); margin-bottom:6px;">Email Admin</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                           style="width:100%; background:var(--hitam-soft); border:1px solid #2c2c2c; color:var(--putih); padding:10px 12px; border-radius:8px;">
                </div>

                <div class="field" style="margin-bottom:18px;">
                    <label for="password" style="display:block; font-size:13px; color:var(--abu); margin-bottom:6px;">Password</label>
                    <input id="password" name="password" type="password" required
                           style="width:100%; background:var(--hitam-soft); border:1px solid #2c2c2c; color:var(--putih); padding:10px 12px; border-radius:8px;">
                </div>

                <button type="submit" class="btn-merah" style="width:100%;">Masuk sebagai Admin</button>
            </form>

            <p class="section-sub" style="text-align:center; margin-top:16px;">
                Bukan admin? <a href="{{ route('login') }}" style="color:var(--merah);">Login sebagai user</a>
            </p>
        </div>
    </div>
</body>
</html>

@extends('layouts.auth')

@section('title', 'Daftar - Bioskopku')

@section('content')
    <h1 class="auth-title">Buat Akun</h1>
    <p class="auth-subtitle">Daftar untuk mulai pesan tiket bioskop favoritmu</p>

    @if ($errors->any())
        <div class="auth-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <div class="field">
            <label for="name">Nama Lengkap</label>
            <input id="name" name="name" type="text" placeholder="Nama sesuai KTP" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="contoh@email.com" value="{{ old('email') }}" required>
        </div>

        <div class="field">
            <label for="phone">Nomor HP</label>
            <input id="phone" name="phone" type="tel" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" required>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Minimal 8 karakter" required minlength="8">
        </div>

        <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi password" required minlength="8">
        </div>

        <button type="submit" class="btn-primary">Daftar Sekarang</button>
    </form>

    <p class="auth-switch">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
@endsection

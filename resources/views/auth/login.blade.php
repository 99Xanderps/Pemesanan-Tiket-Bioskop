@extends('layouts.auth')

@section('title', 'Masuk - Bioskopku')

@section('content')
    <h1 class="auth-title">Selamat Datang</h1>
    <p class="auth-subtitle">Masuk untuk lanjut pesan tiketmu</p>

    @if (session('status'))
        <div class="auth-alert auth-alert--success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="auth-alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="contoh@email.com" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Masukkan password" required>
        </div>

        <label class="checkbox-field">
            <input type="checkbox" name="remember">
            <span>Ingat saya</span>
        </label>

        <button type="submit" class="btn-primary">Masuk</button>
    </form>

    <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
@endsection

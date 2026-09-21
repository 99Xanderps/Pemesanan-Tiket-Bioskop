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

            <!-- Tambahkan divider dan Tombol Google di sini -->
            <div style="text-align: center; margin: 15px 0; color: #888;">atau</div>

            <button type="button" onclick="loginGoogle()" class="btn-primary" style="background-color: #fff; color: #222; border: 1px solid #ccc; display: flex; align-items: center; justify-content: center; width: 100%;">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="width: 18px; margin-right: 10px;">
                Masuk dengan Google
            </button>
        </form>

        <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>

        <!-- Tambahkan Script Firebase SDK v10 di bagian paling bawah -->
        <script type="module">
            import { initializeApp } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
            import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-auth.js";

            // Konfigurasi Firebase Proyekmu
            const firebaseConfig = {
                apiKey: "AIzaSyDNLBnP7724rnm167kOZz3nikuiNfGn36k", // Ganti dengan Web API Key asli dari setting Firebase Console
                authDomain: "pemesanan-tiket-bioskop-83424.firebaseapp.com",
                projectId: "pemesanan-tiket-bioskop-83424",
            };

            const app = initializeApp(firebaseConfig);
            const auth = getAuth(app);
            const provider = new GoogleAuthProvider();

            window.loginGoogle = function() {
                signInWithPopup(auth, provider)
                    .then(async (result) => {
                        const idToken = await result.user.getIdToken();

                        // Kirim token ke backend Laravel
                        fetch("/login-google", { // Sesuaikan dengan route POST Laravel-mu
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ idToken })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                window.location.href = "/main"; // Alihkan setelah sukses login
                            } else {
                                alert('Verifikasi login gagal di server.');
                            }
                        });
                    })
                    .catch((error) => {
                        console.error("Gagal login:", error);
                        alert("Gagal masuk dengan Google: " + error.message);
                    });
            }
        </script>
    @endsection

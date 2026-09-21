<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Ambil variabel idToken yang dikirim dari fungsi fetch() di frontend
        $idTokenString = $request->input('idToken');

        $auth = Firebase::auth();

        try {
            // 1. Verifikasi token ke Firebase
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);

            // 2. Ekstrak data email dan nama dari token
            $email = $verifiedIdToken->claims()->get('email');
            $name = $verifiedIdToken->claims()->get('name');

            // 3. Cari user di database, jika belum ada otomatis daftar (Register)
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => bcrypt(Str::random(24)), // Beri password acak yang kuat
                ]
            );

            // 4. Daftarkan user ke sesi Laravel (Agar terdeteksi bukan guest lagi)
            Auth::login($user);

            // 5. Beri respons sukses ke frontend untuk memicu redirect ke /main
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil login dengan Google'
            ]);

        } catch (\Exception $e) {
            // Jika token kadaluarsa atau salah
            return response()->json([
                'status' => 'error',
                'message' => 'Autentikasi gagal: ' . $e->getMessage()
            ], 401);
        }
    }
}

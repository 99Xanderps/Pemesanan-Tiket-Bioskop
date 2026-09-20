<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin Bioskopku',
            'email'    => 'admin@bioskopku.com',
            'phone'    => '08816062028',
            'password' => Hash::make('akuadmin123'),
            'role'     => 'admin',
        ]);
    }
}

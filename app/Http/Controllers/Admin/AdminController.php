<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'totalMovies'   => Movie::count(),
            'totalCinemas'  => Cinema::count(),
            'totalUsers'    => User::where('role', 'user')->count(),
            'totalBookings' => Booking::count(),
            'totalPaid'     => Booking::where('status', 'paid')->count(),
            'totalRevenue'  => Booking::where('status', 'paid')->sum('total_price'),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}

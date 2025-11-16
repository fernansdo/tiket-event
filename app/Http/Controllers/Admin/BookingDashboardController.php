<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingDashboardController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan daftar semua booking.
     */
    public function index()
    {
        // Ambil semua data booking
        $bookings = Booking::with('user', 'event')->orderBy('created_at', 'desc')->get();

        // Kirim data ke view
        return view('admin.dashboard', ['bookings' => $bookings]);
    }
}
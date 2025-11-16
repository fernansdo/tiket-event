<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menyimpan booking baru.
     */
    public function store(Request $request, Event $event)
    {
        // 1. Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');
        $user = Auth::user();

        // 2. Cek apakah kuota masih tersedia
        if ($event->ticket_quota < $quantity) {
            // Jika kuota tidak cukup, kembalikan dengan pesan error
            return back()->with('error', 'Maaf, kuota tiket tidak mencukupi.');
        }

        // 3. Buat catatan booking baru
        Booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'quantity' => $quantity,
        ]);

        // 4. Kurangi kuota tiket di event
        $event->ticket_quota = $event->ticket_quota - $quantity;
        $event->save();

        // 5. Arahkan pengguna ke dashboard dengan pesan sukses
        // (Nantinya kita bisa buat halaman "My Tickets")
        return redirect('/dashboard')->with('success', 'Tiket berhasil dibooking!');
    }
}
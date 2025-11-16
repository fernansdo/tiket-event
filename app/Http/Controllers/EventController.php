<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage) dengan daftar semua event.
     * Ini adalah halaman publik.
     */
    public function home()
    {
        // 1. Ambil semua data event dari database
        $events = Event::all();

        // 2. Kirim data tersebut ke view 'welcome.blade.php'
        return view('welcome', ['events' => $events]);
    }

    /**
     * Menampilkan daftar semua event (Halaman Admin).
     */
    public function index()
    {
        $events = Event::all();
        return view('events.index', ['events' => $events]);
    }

    /**
     * Menampilkan form untuk membuat event baru (Halaman Admin).
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Menyimpan event baru ke database (Logika Admin).
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'price' => 'required|integer',
            'start_time' => 'required|date',
            'ticket_quota' => 'required|integer',
        ]);

        // Buat objek event baru dan simpan
        Event::create($validatedData);

        // Arahkan kembali pengguna ke halaman daftar event
        return redirect('/events')->with('success', 'Event baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman detail untuk satu event (Halaman Publik).
     */
    public function show(Event $event)
    {
        // $event sudah otomatis diambil oleh Laravel dari ID di URL
        // Kita tinggal mengirimkannya ke view baru
        return view('events.show', ['event' => $event]);
    }

    /**
     * Menampilkan form untuk mengedit event (Halaman Admin).
     */
    public function edit(Event $event)
    {
        return view('events.edit', ['event' => $event]);
    }

    /**
     * Memperbarui event di database (Logika Admin).
     */
    public function update(Request $request, Event $event)
    {
        // Validasi data yang dikirim dari form edit
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'location' => 'required',
            'price' => 'required|integer',
            'start_time' => 'required|date',
            'ticket_quota' => 'required|integer',
        ]);

        // Update data event yang ada dengan data yang sudah divalidasi
        $event->update($validatedData);

        // Arahkan kembali pengguna ke halaman daftar event
        return redirect('/events')->with('success', 'Data event berhasil diperbarui!');
    }

    /**
     * Menghapus event dari database (Logika Admin).
     */
    public function destroy(Event $event)
    {
        // Hapus data event dari database
        $event->delete();

        // Arahkan kembali pengguna ke halaman daftar event
        return redirect('/events')->with('success', 'Event berhasil dihapus!');
    }
}
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController; 
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingDashboardController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses semua orang)
|--------------------------------------------------------------------------
*/
// Halaman depan (Katalog Event) - INI YANG MEMPERBAIKI ERROR VARIABLE $events
Route::get('/', [EventController::class, 'home']);

// Rute publik untuk melihat detail satu event
Route::get('/event-detail/{event}', [EventController::class, 'show']);


/*
|--------------------------------------------------------------------------
| Rute Khusus Pengguna Login (Auth)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup untuk SEMUA pengguna yang sudah login
Route::middleware('auth')->group(function () {
    
    // Rute Profil (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Grup KHUSUS ADMIN
    Route::middleware('admin')->group(function () {
        
        // Rute Dashboard Admin (Lihat Booking)
        Route::get('/admin/dashboard', [BookingDashboardController::class, 'index']);

        // Rute CRUD Event
        Route::get('/events', [EventController::class, 'index']);
        Route::get('/events/create', [EventController::class, 'create']);
        Route::post('/events', [EventController::class, 'store']);
        Route::get('/events/{event}/edit', [EventController::class, 'edit']);
        Route::put('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);
    });

    // Rute untuk memproses booking baru (untuk user biasa)
    Route::post('/booking/{event}', [BookingController::class, 'store']);
    
});

// Memanggil rute auth (login, register, dll)
require __DIR__.'/auth.php';
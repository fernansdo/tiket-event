<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'location',
        'price',
        'start_time',
        'ticket_quota',
    ];

    /**
     * Sebuah Event bisa memiliki banyak booking.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
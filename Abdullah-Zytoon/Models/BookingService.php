<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BookingService extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'service_name',
        'service_price',
        'service_type',
        'quantity',
        'description'
    ];

    // العلاقة مع Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}

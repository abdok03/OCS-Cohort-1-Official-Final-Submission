<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'hall_id', 'event_date', 'start_time',
        'duration', 'guests', 'event_type', 'special_requests',
        'total_amount', 'status', 'admin_notes'
    ];

    protected $casts = [
        'event_date' => 'date',
        'total_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Hall::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scope للاستعلامات
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now());
    }

    // التحقق من التوفر
    public static function isAvailable($venueId, $date, $startTime, $duration)
    {
        $endTime = date('H:i', strtotime("$startTime +$duration hours"));

        return !self::where('venue_id', $venueId)
            ->where('event_date', $date)
            ->where('status', 'approved') // تحقق فقط من الحجوزات المؤكدة
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereRaw('ADDTIME(start_time, SEC_TO_TIME(duration * 3600)) BETWEEN ? AND ?',
                        [$startTime, $endTime]);
            })
            ->exists();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Hall $hall)
    {
        $hall->load('images');
        if ($hall->images->count() == 0) {
        // لا توجد صور
        $hasImages = false;
    } else {
        $hasImages = true;
        $firstImage = $hall->images->first();
    }
        $bookedDates = Booking::where('hall_id', $hall->id)
            ->where('status', 'confirmed')
            ->pluck('event_date')
            ->map(function($date) {
                return $date->format('Y-m-d');
            })
            ->toArray();

        return view('bookings.create', compact('hall', 'bookedDates','hasImages', 'firstImage'));
    //      dd([
    //     'hall_id' => $hall->id,
    //     'hall_name' => $hall->name,
    //     'view_path' => 'bookings.create',
    //     'file_exists' => file_exists(resource_path('views/bookings/create.blade.php'))
    // ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hall_id' => 'required|exists:halls,id',
            'event_date' => 'required|date|after:today',
            'selected_time' => 'required',
            'duration' => 'required|integer|min:1',
            'guests' => 'required|integer|min:1|max:' . Hall::find($request->hall_id)->capacity_max,
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // حساب السعر
        $hall = Hall::find($request->hall_id);
        $basePrice = $hall->price_per_hour * $request->duration;
        $servicesPrice = 0; // يمكن حسابها من الـ services
        $serviceFee = ($basePrice + $servicesPrice) * 0.1;
        $taxes = ($basePrice + $servicesPrice) * 0.08;
        $totalPrice = $basePrice + $servicesPrice + $serviceFee + $taxes;

        // إنشاء الحجز
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'hall_id' => $hall->id,
            'event_date' => $request->event_date,
            'start_time' => $request->selected_time,
            'duration' => $request->duration,
            'guests' => $request->guests,
            'special_requests' => $request->special_requests,
            'base_price' => $basePrice,
            'services_price' => $servicesPrice,
            'service_fee' => $serviceFee,
            'taxes' => $taxes,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'booking_id' => $booking->id,
            'message' => 'Booking created successfully'
        ]);
    }

    public function confirmation(Booking $booking)
    {
        $booking->load('hall', 'user');
        return view('bookings.confirmation', compact('booking'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create(Hall $hall)
    {
$hall->load(['images', 'categories', 'user']);
    if ($hall->images->count() == 0) {
        $hasImages = false;
    } else {
        $hasImages = true;
        $firstImage = $hall->images->first();
    }
          $bookedDates = \App\Models\Booking::where('hall_id', $hall->id)
        ->whereIn('status', ['confirmed', 'pending'])
        ->pluck('event_date')
        ->map(function($date) {
            return $date->format('Y-m-d');
        })
        ->unique()
        ->toArray();

    $dynamicData = [
        'amenities' => $this->getHallAmenities($hall),
        'highlights' => $this->getHallHighlights($hall),
        'similar_halls' => $this->getSimilarHalls($hall),
    ];

  return view('bookings.create', array_merge(
        compact('hall', 'bookedDates'),
        $dynamicData
    ));    //      dd([
    //     'hall_id' => $hall->id,
    //     'hall_name' => $hall->name,
    //     'view_path' => 'bookings.create',
    //     'file_exists' => file_exists(resource_path('views/bookings/create.blade.php'))
    // ]);
    }

private function getHallAmenities($hall)
{
    return [
        ['icon' => 'wifi', 'text' => 'واي فاي عالي السرعة'],
        ['icon' => 'parking', 'text' => 'مواقف مجانية'],
        ['icon' => 'snowflake', 'text' => 'تكييف مركزي'],
        ['icon' => 'utensils', 'text' => 'خدمات كيترينغ'],
        ['icon' => 'music', 'text' => 'نظام صوتي متكامل'],
        ['icon' => 'lightbulb', 'text' => 'إضاءة احترافية'],
    ];
}

private function getHallHighlights($hall)
{
    $highlights = [
        "سعة تصل إلى {$hall->capacity_max} ضيف",
        "تصميم داخلي فاخر",
        "فريق خدمة متخصص",
    ];

    if ($hall->price_per_hour < 100) {
        $highlights[] = "أسعار تنافسية";
    }

    if ($hall->categories->count() > 0) {
        $categoryNames = $hall->categories->pluck('name')->implode(', ');
        $highlights[] = "مصنفة تحت: {$categoryNames}";
    }

    return $highlights;
}

private function getSimilarHalls($currentHall)
{
    return \App\Models\Hall::where('id', '!=', $currentHall->id)
        ->where('status', 1)
        ->where('city', $currentHall->city)
        ->with(['images', 'categories'])
        ->limit(3)
        ->get()
        ->map(function($hall) {
            return [
                'id' => $hall->id,
                'name' => $hall->name,
                'price_per_day' => $hall->price_per_day,
                'image' => $hall->images->first()
                    ? asset('storage/' . $hall->images->first()->image_path)
                    : 'https://via.placeholder.com/300x200',
                'category' => $hall->categories->first()->name ?? 'قاعة أفراح',
                'location' => $hall->city,
            ];
        });

    }

    public function store(Request $request)
    {
    // \Log::info('Booking Request:', $request->all());
    $services = json_decode($request->input('services_json'), true) ?? [];
        $request->validate([
            'hall_id' => 'required|exists:halls,id',
            'event_date' => 'required|date|after:today',
            'selected_time' => 'required',
            'duration' => 'required|integer|min:1',
            'guests' => 'required|integer|min:1|max:' . Hall::find($request->hall_id)->capacity_max,
            'special_requests' => 'nullable|string|max:1000',
        ]);

        $hall = Hall::find($request->hall_id);
        $basePrice = $hall->price_per_hour * $request->duration;
        $servicesPrice = 0; // يمكن حسابها من الـ services
        $serviceFee = ($basePrice + $servicesPrice) * 0.1;
        $taxes = ($basePrice + $servicesPrice) * 0.08;
        $totalPrice = $basePrice + $servicesPrice + $serviceFee + $taxes;

        // إنشاء الحجز
        $endTime = date('H:i', strtotime($request->selected_time . " + {$request->duration} hours"));

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'hall_id' => $hall->id,
            'event_date' => $request->event_date,
            'start_time' => $request->selected_time,
            'end_time' => $endTime,
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






    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('admin');
    // }

    // عرض جميع طلبات الحجز
    // عرض جميع طلبات الحجز (للأدمن)
    public function index(Request $request)
    {
        $query = Booking::with(['hall', 'user'])->latest();

        // Filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $bookings = $query->paginate(20);

        // Statistics
        $stats = [
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved_by_admin')->count(),
            'rejected' => Booking::where('status', 'rejected_by_admin')->count(),
            'total' => Booking::count(),
            'today' => Booking::whereDate('created_at', today())->count(),
            'this_month' => Booking::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'stats'));
    }

    // عرض حجوزات المستخدم
    public function userBookings()
    {
        $bookings = Booking::with('hall')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('pages.my-bookings', compact('bookings'));
    }

    // عرض طلب حجز معين
    public function show(Booking $booking)
    {
        $booking->load(['hall', 'user', 'hall.images']);

        // Booking history
        $history = [
            'created_at' => $booking->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $booking->updated_at->format('Y-m-d H:i:s'),
        ];

        return view('admin.bookings.show', compact('booking', 'history'));
    }

    // الموافقة على طلب الحجز
    public function approve(Request $request, Booking $booking)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => 'approved_by_admin',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
            'admin_notes' => $request->notes,
        ]);

        // Send notification to user
        // $this->sendApprovalNotification($booking);

        // // Send notification to hall owner (إذا أردت)
        // $this->notifyHallOwner($booking);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking approved successfully!');
    }

    // رفض طلب الحجز
    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected_by_admin',
            'rejected_at' => now(),
            'rejected_by' => Auth::id(),
            'rejection_reason' => $request->reason,
            'admin_notes' => $request->notes,
        ]);

        // Send notification to user
        // $this->sendRejectionNotification($booking);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking rejected.');
    }

    // تحديث حالة الحجز (Unified Method)
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:approved_by_admin,rejected_by_admin,confirmed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $status = $request->status;
        $updateData = ['status' => $status];

        if ($status == 'approved_by_admin') {
            $updateData['approved_at'] = now();
            $updateData['approved_by'] = Auth::id();
            $msg = 'Booking approved successfully.';
        } elseif ($status == 'rejected_by_admin') {
            $updateData['rejected_at'] = now();
            $updateData['rejected_by'] = Auth::id();
            $updateData['rejection_reason'] = $request->notes ?? 'No reason provided';
            $msg = 'Booking rejected.';
        } elseif ($status == 'confirmed') {
            $updateData['payment_status'] = 'paid';
            $updateData['payment_confirmed_at'] = now();
            $updateData['payment_confirmed_by'] = Auth::id();
            $msg = 'Booking confirmed and marked as paid.';
        } else {
            $msg = 'Booking status updated.';
        }

        if ($request->has('notes')) {
            $updateData['admin_notes'] = $request->notes;
        }

        $booking->update($updateData);

        return back()->with('success', $msg);
    }

    // عرض إحصائيات
    public function dashboard()
    {
        // Recent bookings
        $recentBookings = Booking::with(['hall', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // Statistics
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_price'),
            'total_halls' => Hall::count(),
            'total_users' => User::count(),
        ];

        // Chart data (آخر 7 أيام)
        $chartData = $this->getBookingChartData();

        return view('pages.dashboard', compact('recentBookings', 'stats', 'chartData'));
    }

    public function destroy(Booking $booking)
    {
        // التحقق من الصلاحية (أن المستخدم هو صاحب الحجز أو أدمن)
        // for now just delete
        $booking->delete();

        return back()->with('success', 'Booking cancelled successfully');
    }

    private function getBookingChartData()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[$date] = Booking::whereDate('created_at', $date)->count();
        }

        return $data;
    }

    // صفحة الدفع
    public function checkout(Booking $booking)
    {
        // تأكد أن الحجز مؤهل للدفع - دعم كلاً من الحالتين
        $allowedStatuses = ['approved', 'approved_by_admin'];
        if (!in_array($booking->status, $allowedStatuses)) {
            return redirect()->route('user.bookings')->with('error', 'Booking is not ready for payment. Current status: ' . $booking->status);
        }
        
        $booking->load('hall');
        return view('bookings.checkout', compact('booking'));
    }

    // معالجة الدفع (محاكاة)
    public function processPayment(Request $request, Booking $booking)
    {
        // هنا يمكن ربط بوابة دفع حقيقية مثل Stripe/PayPal
        // سنفترض أن الدفع تم بنجاح

        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'payment_confirmed_at' => now(),
            'payment_method' => $request->payment_method ?? 'card',
        ]);

        return redirect()->route('user.bookings')->with('success', 'Payment successful! Your booking is confirmed.');
    }
}

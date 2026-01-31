<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Hall;
use App\Models\Booking;
use App\Models\BookingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingComponent extends Component

{
     public $layout = 'layouts.user';
    // بيانات القاعة
    public $hall;
    public $hallId;

    // الخطوة الحالية
    public $currentStep = 1;

    // بيانات الحجز
    public $selectedDate;
    public $selectedTime;
    public $duration = 4;
    public $guests = 100;
    public $specialRequests = '';
    public $paymentMethod = 'card';
    public $isMixed = false;

    // الخدمات الإضافية
    public $selectedServices = [];

    // بيانات الدفع
    public $cardNumber;
    public $cardExpiry;
    public $cardCvv;
    public $cardName;
    public $agreeTerms = false;

    // التقويم
    public $currentMonth;
    public $currentYear;
    public $bookedDates = [];

    // ساعات العمل
    public $availableTimes = [
        '08:00 AM', '10:00 AM', '12:00 PM',
        '02:00 PM', '04:00 PM', '06:00 PM', '08:00 PM'
    ];

    // الخدمات المتاحة
    public $dynamicServices = [];

    // مدة الخيارات
    public $durationOptions = [2,4, 6, 8, 12];

    // تهيئة المكون
    public function mount($hallId)
    {
        $this->hallId = $hallId;
        $this->hall = Hall::with(['images', 'services'])->findOrFail($hallId);
        $this->dynamicServices = $this->hall->services()->where('is_active', true)->get();

        // تهيئة التقويم
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;

        // جلب التواريخ المحجوزة
        $this->loadBookedDates();
    }

    // جلب التواريخ المحجوزة
    public function loadBookedDates()
    {
        $this->bookedDates = Booking::where('hall_id', $this->hallId)
            ->where('status', 'confirmed')
            ->pluck('event_date')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();
    }

    // تغيير الخطوة
    public function goToStep($step)
    {
        // التحقق قبل الانتقال
        if ($step == 2 && !$this->validateStep1()) {
            return;
        }

        if ($step == 3 && !$this->validateStep2()) {
            return;
        }

        $this->currentStep = $step;

        // تحديث الحسابات عند الانتقال للخطوة 3
        if ($step == 3) {
            $this->calculatePrices();
        }

        $this->dispatch('step-changed', step: $step);
    }

    // التحقق من الخطوة 1
    public function validateStep1()
    {
        $this->validate([
            'selectedDate' => 'required|date|after:today',
            'selectedTime' => 'required|string',
            'duration' => 'required|integer|min:1',
            'guests' => 'required|integer|min:1|max:' . $this->hall->capacity_max
        ], [
            'selectedDate.required' => 'Please select a date',
            'selectedTime.required' => 'Please select a time',
            'guests.max' => 'Maximum capacity is ' . $this->hall->capacity_max . ' guests'
        ]);

        return true;
    }

    // التحقق من الخطوة 2
    public function validateStep2()
    {
        // لا يوجد تحقق إجباري للخدمات
        return true;
    }

    // اختيار التاريخ
    public function selectDate($date)
    {
        $selectedDate = Carbon::create($this->currentYear, $this->currentMonth, $date);

        // التحقق إذا كان التاريخ متاحاً
        $dateStr = $selectedDate->format('Y-m-d');

        if ($selectedDate->isPast()) {
            $this->addError('selectedDate', 'Cannot select past dates');
            return;
        }

        if (in_array($dateStr, $this->bookedDates)) {
            $this->addError('selectedDate', 'This date is already booked');
            return;
        }

        $this->selectedDate = $dateStr;
        $this->resetValidation('selectedDate');
    }

    // اختيار الوقت
    public function selectTime($time)
    {
        $this->selectedTime = $time;
    }

    // اختيار المدة
    public function selectDuration($hours)
    {
        $this->duration = $hours;
    }

    // تحديث عدد الضيوف
    public function updateGuests($change)
    {
        $newValue = $this->guests + $change;

        if ($newValue >= 1 && $newValue <= $this->hall->capacity_max) {
            $this->guests = $newValue;
        }
    }

    public function toggleService($serviceId)
    {
        $serviceId = (int)$serviceId;
        if (in_array($serviceId, $this->selectedServices)) {
            $this->selectedServices = array_values(array_diff($this->selectedServices, [$serviceId]));
        } else {
            $this->selectedServices[] = $serviceId;
        }
    }

    // التنقل بين الشهور
    public function prevMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
    }

    // حساب الأسعار
    public function calculatePrices()
    {
        $calculations = [
            'venue_price' => 0,
            'services_price' => 0,
            'service_fee' => 0,
            'taxes' => 0,
            'total' => 0,
            'deposit' => 0
        ];

        // سعر القاعة
        $calculations['venue_price'] = $this->hall->price_per_hour * $this->duration;

        // سعر الخدمات
        foreach ($this->selectedServices as $serviceId) {
            $service = $this->dynamicService->firstWhere('id', $serviceId);
            if ($service) {
                // All newly added services are 'fixed' for now as per current schema
                $calculations['services_price'] += $service->price;
            }
        }

        // الرسوم
        $subtotal = $calculations['venue_price'] + $calculations['services_price'];
        $calculations['service_fee'] = $subtotal * 0.10;
        $calculations['taxes'] = $subtotal * 0.08;

        // المجموع
        $calculations['total'] = $subtotal + $calculations['service_fee'] + $calculations['taxes'];
        $calculations['deposit'] = $calculations['total'] * 0.25;

        return $calculations;
    }

    public function getSelectedServicesDetails()
    {
        return $this->dynamicService
            ->filter(function ($service) {
                return in_array($service->id, $this->selectedServices);
            })
            ->values();
    }

    // إرسال الحجز
    public function submitBooking()
    {
        $this->validate([
            'agreeTerms' => 'accepted',
        ], [
            'agreeTerms.accepted' => 'You must agree to the terms and conditions',
        ]);

        try {
            $startTime = Carbon::parse($this->selectedTime);
            $endTime = $startTime->copy()->addHours($this->duration);

            // إنشاء الحجز
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'hall_id' => $this->hall->id,
                'event_date' => $this->selectedDate,
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'guests' => $this->guests,
                'total_price' => $this->calculatePrices()['total'],
                'special_requests' => $this->specialRequests,
                'status' => 'pending',
                'event_type' => 'Wedding',
                'is_mixed' => $this->isMixed,
            ]);

            // إضافة الخدمات
            foreach ($this->getSelectedServicesDetails() as $service) {
                BookingService::create([
                    'booking_id' => $booking->id,
                    'service_name' => $service->name,
                    'service_price' => $service->price,
                    'service_type' => 'fixed'
                ]);
            }

            // إعادة تعيين النموذج
            $this->resetForm();

            // عرض رسالة النجاح
            session()->flash('booking_success', [
                'reference' => 'BK-' . $booking->id,
                'message' => 'Booking confirmed successfully!'
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }

    // إعادة تعيين النموذج
    private function resetForm()
    {
        $this->currentStep = 1;
        $this->selectedDate = null;
        $this->selectedTime = null;
        $this->duration = 4;
        $this->guests = 100;
        $this->selectedServices = [];
        $this->specialRequests = '';
        $this->agreeTerms = false;
    }

    // توليد أيام الشهر
    public function getDaysInMonth()
    {
        $daysInMonth = Carbon::create($this->currentYear, $this->currentMonth)->daysInMonth;
        $days = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($this->currentYear, $this->currentMonth, $day);
            $dateStr = $date->format('Y-m-d');

            $days[] = [
                'day' => $day,
                'date' => $dateStr,
                'is_past' => $date->isPast(),
                'is_booked' => in_array($dateStr, $this->bookedDates),
                'is_selected' => $this->selectedDate == $dateStr
            ];
        }

        return $days;
    }

    // اسم الشهر الحالي
    public function getCurrentMonthNameProperty()
    {
        return Carbon::create()->month($this->currentMonth)->format('F Y');
    }

    // هل الخدمة محددة؟
    public function isServiceSelected($serviceId)
    {
        return in_array($serviceId, $this->selectedServices);
    }

    // حساب الأسعار للعرض
    public function getPricesProperty()
    {
        return $this->calculatePrices();
    }

    // عرض المكون
    public function render()
    {
        return view('livewire.booking-component', [
            'days' => $this->getDaysInMonth(),
            'calculations' => $this->calculatePrices()
        ]);
    }
}

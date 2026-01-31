@extends('layouts.user')

@section('title', 'Book ' . $hall->name)

@section('content')
    <style>
        /* أنسخ CSS الخاص بالتنسيقات الجديدة */
        :root {
            --primary-gold: #D4AF37;
            --secondary-gold: #F4E4B5;
        }

        .stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3rem;
            position: relative;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: #eee;
            z-index: 1;
        }

        .step {
            position: relative;
            z-index: 2;
            background: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-align: center;
            font-weight: 600;
            color: #999;
            border: 2px solid #eee;
            min-width: 150px;
        }

        .step.active {
            border-color: var(--primary-gold);
            color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.1);
        }

        .step.completed {
            border-color: #28a745;
            color: #28a745;
            background: rgba(40, 167, 69, 0.1);
        }

        .step .number {
            display: block;
            width: 30px;
            height: 30px;
            background: #eee;
            border-radius: 50%;
            margin: 0 auto 5px;
            line-height: 30px;
            font-size: 14px;
        }

        .step.active .number {
            background: var(--primary-gold);
            color: white;
        }

        .step.completed .number {
            background: #28a745;
            color: white;
        }

        .date-picker {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            text-align: center;
        }

        .date-day {
            padding: 15px 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .date-day:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        .date-day.selected {
            background: var(--primary-gold);
            color: white;
            border-color: var(--primary-gold);
        }

        .date-day.unavailable {
            background: #f8f9fa;
            color: #ccc;
            cursor: not-allowed;
            text-decoration: line-through;
        }

        .time-slot {
            padding: 12px 20px;
            border: 2px solid #eee;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .time-slot:hover {
            border-color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.05);
        }

        .time-slot.selected {
            border-color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.1);
            color: var(--primary-gold);
            font-weight: 600;
        }

        .time-slot.unavailable {
            background: #f8f9fa;
            color: #ccc;
            cursor: not-allowed;
            border-color: #eee;
        }

        .summary-card {
            position: sticky;
            top: 100px;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
        }

        .price-breakdown {
            border-top: 1px solid #eee;
            padding-top: 20px;
            margin-top: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .price-row.total {
            font-weight: 700;
            font-size: 1.2rem;
            border-top: 2px solid #eee;
            padding-top: 15px;
            margin-top: 15px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .month-nav {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-gold);
            cursor: pointer;
        }

        .service-option {
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .service-option:hover {
            border-color: var(--primary-gold);
        }

        .service-option.selected {
            border-color: var(--primary-gold);
            background: rgba(212, 175, 55, 0.05);
        }

        .service-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid #ddd;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }

        .service-option.selected .service-checkbox {
            background: var(--primary-gold);
            border-color: var(--primary-gold);
        }

        .service-option.selected .service-checkbox::after {
            content: '✓';
            color: white;
            display: block;
            text-align: center;
            line-height: 16px;
            font-size: 12px;
        }
    </style>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="breadcrumb-luxury">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('explore') }}">Venues</a></li>
                <li class="breadcrumb-item"><a href="{{ route('venue.details', $hall->id) }}">{{ $hall->name }}</a></li>
                <li class="breadcrumb-item active">Book Now</li>
            </ol>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row">
            <!-- الخطوات الرئيسية -->
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-body p-4 p-lg-5">
                        <!-- Stepper -->
                        <div class="stepper">
                            <div class="step active" id="step1">
                                <div class="number">1</div>
                                <span>Select Date & Time</span>
                            </div>
                            <div class="step" id="step2">
                                <div class="number">2</div>
                                <span>Add Services</span>
                            </div>
                            <div class="step" id="step3">
                                <div class="number">3</div>
                                <span>Review & Pay</span>
                            </div>
                        </div>

                        <!-- Step 1: Date & Time Selection -->
                        <div id="step1Content" class="step-content">
                            <h3 class="fw-bold mb-4">Select Your Event Date & Time</h3>

                            <!-- Calendar -->
                            <div class="mb-5">
                                <div class="calendar-header">
                                    <h5 class="fw-bold mb-0" id="currentMonth">April 2024</h5>
                                    <div>
                                        <button class="month-nav" onclick="prevMonth()">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button class="month-nav" onclick="nextMonth()">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="date-picker" id="calendar">
                                    <!-- Days will be generated by JavaScript -->
                                </div>

                                <input type="hidden" name="selected_date" id="selectedDate">
                            </div>

                            <!-- Time Selection -->
                            <div class="mb-4">
                                <h5 class="mb-3">Select Time Slot</h5>
                                <div class="row" id="timeSlots">
                                    <!-- Time slots will be generated -->
                                </div>
                                <input type="hidden" name="selected_time" id="selectedTime">
                            </div>

                            <!-- Duration -->
                            <div class="mb-5">
                                <h5 class="mb-3">Event Duration</h5>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <div class="time-slot" data-hours="4" onclick="selectDuration(4)">
                                            4 hours
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="time-slot" data-hours="6" onclick="selectDuration(6)">
                                            6 hours
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="time-slot" data-hours="8" onclick="selectDuration(8)">
                                            8 hours
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="time-slot" data-hours="12" onclick="selectDuration(12)">
                                            12 hours
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="duration" id="selectedDuration" value="4">
                            </div>

                            <!-- Guest Count -->
                            <div class="mb-5">
                                <h5 class="mb-3">Number of Guests</h5>
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="updateGuests(-10)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center" name="guests"
                                                id="guestCount" value="100" min="1"
                                                max="{{ $hall->capacity_max }}">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="updateGuests(10)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            Maximum capacity: {{ $hall->capacity_max }} guests
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('venue.details', $hall->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Back to Venue
                                </a>
                                <button class="btn btn-primary" onclick="goToStep(2)">
                                    Continue to Services <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Additional Services -->
                        <div id="step2Content" class="step-content" style="display: none;">
                            <h3 class="fw-bold mb-4">Add Extra Services (Optional)</h3>

                            <!-- Services List -->
                            <div class="services-list">
                                <div class="service-option" onclick="toggleService(this)" data-price="500">
                                    <div class="d-flex align-items-center">
                                        <span class="service-checkbox"></span>
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-1">Professional Photography</h6>
                                            <p class="text-muted mb-2">8 hours coverage with 500+ edited photos</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-primary">$500</span>
                                                <small class="text-muted">+$500</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="service-option" onclick="toggleService(this)" data-price="300">
                                    <div class="d-flex align-items-center">
                                        <span class="service-checkbox"></span>
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-1">Sound System & DJ</h6>
                                            <p class="text-muted mb-2">Professional sound system with DJ service</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-primary">$300</span>
                                                <small class="text-muted">+$300</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="service-option" onclick="toggleService(this)" data-price="200">
                                    <div class="d-flex align-items-center">
                                        <span class="service-checkbox"></span>
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-1">Decoration Package</h6>
                                            <p class="text-muted mb-2">Full venue decoration with flowers and lighting</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-primary">$200</span>
                                                <small class="text-muted">+$200</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="service-option" onclick="toggleService(this)" data-price="150">
                                    <div class="d-flex align-items-center">
                                        <span class="service-checkbox"></span>
                                        <div class="ms-3">
                                            <h6 class="fw-bold mb-1">Catering Service</h6>
                                            <p class="text-muted mb-2">Buffet for up to {{ $hall->capacity_max }} guests
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-primary">$150</span>
                                                <span class="text-muted">Per 10 guests</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Requests -->
                            <div class="mb-5 mt-4">
                                <h5 class="mb-3">Special Requests</h5>
                                <textarea class="form-control" name="special_requests" rows="4"
                                    placeholder="Any special requirements or requests..."></textarea>
                            </div>

                            <!-- Navigation -->
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-secondary" onclick="goToStep(1)">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                                <button class="btn btn-primary" onclick="goToStep(3)">
                                    Review & Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Review & Payment -->
                        <div id="step3Content" class="step-content" style="display: none;">
                            <h3 class="fw-bold mb-4">Review Your Booking</h3>

                            <!-- Booking Summary -->
                            <div class="booking-summary mb-5">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5 class="fw-bold mb-3">Event Details</h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Venue:</strong></td>
                                                <td>{{ $hall->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Date:</strong></td>
                                                <td id="reviewDate">-</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Time:</strong></td>
                                                <td id="reviewTime">-</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Duration:</strong></td>
                                                <td id="reviewDuration">-</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Guests:</strong></td>
                                                <td id="reviewGuests">-</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h5 class="fw-bold mb-3">Selected Services</h5>
                                        <ul class="list-group" id="reviewServices">
                                            <li class="list-group-item border-0 px-0">No additional services</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Form -->
                            <div class="payment-form mb-5">
                                <h5 class="fw-bold mb-3">Payment Details</h5>

                                <div class="mb-4">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="creditCard" value="card" checked>
                                        <label class="form-check-label" for="creditCard">
                                            <i class="fas fa-credit-card me-2"></i> Credit/Debit Card
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                            id="paypal" value="paypal">
                                        <label class="form-check-label" for="paypal">
                                            <i class="fab fa-paypal me-2"></i> PayPal
                                        </label>
                                    </div>
                                </div>

                                <div id="cardForm">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label>Card Number</label>
                                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Expiry Date</label>
                                            <input type="text" class="form-control" placeholder="MM/YY">
                                        </div>
                                        <div class="col-md-3">
                                            <label>CVV</label>
                                            <input type="text" class="form-control" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label>Cardholder Name</label>
                                        <input type="text" class="form-control" placeholder="John Doe">
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    A 25% deposit is required to confirm your booking. The remaining amount
                                    will be charged 7 days before your event.
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-5">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms">
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#">Terms & Conditions</a> and
                                        <a href="#">Cancellation Policy</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Navigation -->
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-secondary" onclick="goToStep(2)">
                                    <i class="fas fa-arrow-left me-2"></i> Back
                                </button>
                                <button class="btn btn-success btn-lg px-5" onclick="submitBooking()">
                                    <i class="fas fa-lock me-2"></i> Confirm & Pay Deposit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <!-- Venue Info -->
                    <div class="d-flex align-items-center mb-4">
                        @if ($hall->images->count() > 0)
                            <div class="text-center mb-4">
                                <img src="{{ asset('storage/' . $hall->images->first()->image_path) }}"
                                    alt="{{ $hall->name }}"
                                    style="width: 100%; max-height: 200px; object-fit: cover; border-radius: 10px;">
                            </div>
                        @else
                            <div class="text-center mb-4">
                                <div class="placeholder-image"
                                    style="width: 100%; height: 200px; background: #f0f0f0; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                    <p class="text-muted mt-2">No image available</p>
                                </div>
                            </div>
                        @endif
                        <div class="ms-3">
                            <h6 class="fw-bold mb-1">{{ $hall->name }}</h6>
                            <small class="text-muted">
                                <i class="fas fa-map-marker-alt me-1"></i>
                                {{ $hall->city }}
                            </small>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="price-breakdown">
                        <div class="price-row">
                            <span>Venue Rental (4 hours)</span>
                            <span id="venuePrice">${{ number_format($hall->price_per_hour * 4) }}</span>
                        </div>
                        <div class="price-row">
                            <span>Additional Services</span>
                            <span id="servicesPrice">$0</span>
                        </div>
                        <div class="price-row">
                            <span>Service Fee (10%)</span>
                            <span id="serviceFee">${{ number_format($hall->price_per_hour * 4 * 0.1) }}</span>
                        </div>
                        <div class="price-row">
                            <span>Taxes (8%)</span>
                            <span id="taxes">${{ number_format($hall->price_per_hour * 4 * 0.08) }}</span>
                        </div>
                        <div class="price-row total">
                            <span>Total</span>
                            <span id="totalPrice">${{ number_format($hall->price_per_hour * 4 * 1.18) }}</span>
                        </div>
                        <div class="price-row">
                            <small class="text-muted">Deposit (25%)</small>
                            <small class="text-muted" id="depositAmount">
                                ${{ number_format($hall->price_per_hour * 4 * 1.18 * 0.25) }}
                            </small>
                        </div>
                    </div>

                    <!-- Help Info -->
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="help-icon">
                                <i class="fas fa-shield-alt text-success"></i>
                            </div>
                            <div class="ms-3">
                                <small class="fw-bold">Secure Booking</small>
                                <small class="text-muted d-block">Your payment is protected</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="help-icon">
                                <i class="fas fa-undo-alt text-info"></i>
                            </div>
                            <div class="ms-3">
                                <small class="fw-bold">Flexible Cancellation</small>
                                <small class="text-muted d-block">Free cancellation up to 7 days</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <div class="checkmark-circle mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Booking Confirmed!</h4>
                    <p class="text-muted mb-4">
                        Your booking request has been submitted successfully.
                        We will contact you within 24 hours to confirm the details.
                    </p>
                    <div class="booking-reference mb-4">
                        <small class="text-muted">Booking Reference</small>
                        <div class="fw-bold text-primary">#BK-{{ strtoupper(uniqid()) }}</div>
                    </div>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i> Home
                        </a>
                        <a href="{{ route('user.bookings') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-alt me-2"></i> My Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // متغيرات التخزين
        let selectedDate = null;
        let selectedTime = null;
        let selectedDuration = 4;
        let guestCount = 100;
        let selectedServices = [];
        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();

        // دالة تغيير الخطوات
        function goToStep(step) {
            // إخفاء جميع الخطوات
            document.querySelectorAll('.step-content').forEach(content => {
                content.style.display = 'none';
            });

            // إظهار الخطوة المطلوبة
            document.getElementById(`step${step}Content`).style.display = 'block';

            // تحديث الـ Stepper
            document.querySelectorAll('.step').forEach(s => {
                s.classList.remove('active', 'completed');
            });

            for (let i = 1; i <= step; i++) {
                const stepElement = document.getElementById(`step${i}`);
                if (i === step) {
                    stepElement.classList.add('active');
                } else {
                    stepElement.classList.add('completed');
                }
            }

            // تحديث ملخص المراجعة إذا كانت الخطوة 3
            if (step === 3) {
                updateReviewSummary();
            }

            // تحديث الحسابات
            updateCalculations();
        }

        // توليد التقويم
        function generateCalendar() {
            const calendar = document.getElementById('calendar');
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // تحديث عنوان الشهر
            document.getElementById('currentMonth').textContent =
                `${monthNames[currentMonth]} ${currentYear}`;

            // مسح التقويم السابق
            calendar.innerHTML = '';

            // إضافة أيام الأسبوع
            const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            daysOfWeek.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'fw-bold text-muted';
                dayElement.textContent = day;
                calendar.appendChild(dayElement);
            });

            // حساب أول يوم في الشهر
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();

            // عدد الأيام في الشهر
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

            // إضافة فراغات للأيام السابقة
            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                calendar.appendChild(empty);
            }

            // إضافة أيام الشهر
            const today = new Date();
            const bookedDates = @json($bookedDates ?? []);

            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(currentYear, currentMonth, day);
                const dateStr = date.toISOString().split('T')[0];

                const dayElement = document.createElement('div');
                dayElement.className = 'date-day';
                dayElement.textContent = day;

                // التحقق من التواريخ
                if (date < today.setHours(0, 0, 0, 0)) {
                    dayElement.classList.add('unavailable');
                    dayElement.title = 'Past date';
                } else if (bookedDates.includes(dateStr)) {
                    dayElement.classList.add('unavailable');
                    dayElement.title = 'Already booked';
                } else {
                    dayElement.onclick = () => selectDate(dateStr, dayElement);

                    if (selectedDate === dateStr) {
                        dayElement.classList.add('selected');
                    }
                }

                calendar.appendChild(dayElement);
            }
        }

        // اختيار التاريخ
        function selectDate(date, element) {
            selectedDate = date;

            // إزالة التحديد السابق
            document.querySelectorAll('.date-day').forEach(day => {
                day.classList.remove('selected');
            });

            // إضافة التحديد الجديد
            element.classList.add('selected');

            // توليد الوقت المتاح
            generateTimeSlots();

            // تحديث الحسابات
            updateCalculations();
        }

        // توليد الوقت المتاح
        function generateTimeSlots() {
            const timeSlots = document.getElementById('timeSlots');
            timeSlots.innerHTML = '';

            if (!selectedDate) return;

            const times = [
                '08:00 AM', '10:00 AM', '12:00 PM',
                '02:00 PM', '04:00 PM', '06:00 PM', '08:00 PM'
            ];

            times.forEach(time => {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';

                const slot = document.createElement('div');
                slot.className = 'time-slot';
                slot.textContent = time;
                slot.onclick = () => selectTime(time, slot);

                if (selectedTime === time) {
                    slot.classList.add('selected');
                }

                col.appendChild(slot);
                timeSlots.appendChild(col);
            });
        }

        // اختيار الوقت
        function selectTime(time, element) {
            selectedTime = time;

            // إزالة التحديد السابق
            document.querySelectorAll('.time-slot').forEach(slot => {
                slot.classList.remove('selected');
            });

            // إضافة التحديد الجديد
            element.classList.add('selected');

            // تحديث الحسابات
            updateCalculations();
        }

        // اختيار المدة
        function selectDuration(hours) {
            selectedDuration = hours;

            // إزالة التحديد السابق
            document.querySelectorAll('.time-slot[data-hours]').forEach(slot => {
                slot.classList.remove('selected');
            });

            // إضافة التحديد الجديد
            event.target.classList.add('selected');
            document.getElementById('selectedDuration').value = hours;

            // تحديث الحسابات
            updateCalculations();
        }

        // تحديث عدد الضيوف
        function updateGuests(change) {
            const input = document.getElementById('guestCount');
            let value = parseInt(input.value) + change;
            const max = parseInt(input.max);

            if (value < 1) value = 1;
            if (value > max) value = max;

            input.value = value;
            guestCount = value;

            // تحديث الحسابات
            updateCalculations();
        }

        // تفعيل/تعطيل الخدمة
        function toggleService(element) {
            element.classList.toggle('selected');

            const serviceName = element.querySelector('h6').textContent;
            const servicePrice = parseFloat(element.dataset.price);

            if (element.classList.contains('selected')) {
                selectedServices.push({
                    name: serviceName,
                    price: servicePrice
                });
            } else {
                selectedServices = selectedServices.filter(s => s.name !== serviceName);
            }

            // تحديث الحسابات
            updateCalculations();
        }

        // تحديث الحسابات
        function updateCalculations() {
            const hourlyRate = {{ $hall->price_per_hour }};
            const basePrice = hourlyRate * selectedDuration;
            const servicesPrice = selectedServices.reduce((sum, service) => sum + service.price, 0);
            const serviceFee = (basePrice + servicesPrice) * 0.1;
            const taxes = (basePrice + servicesPrice) * 0.08;
            const total = basePrice + servicesPrice + serviceFee + taxes;
            const deposit = total * 0.25;

            // تحديث العرض
            document.getElementById('venuePrice').textContent = `$${basePrice.toFixed(2)}`;
            document.getElementById('servicesPrice').textContent = `$${servicesPrice.toFixed(2)}`;
            document.getElementById('serviceFee').textContent = `$${serviceFee.toFixed(2)}`;
            document.getElementById('taxes').textContent = `$${taxes.toFixed(2)}`;
            document.getElementById('totalPrice').textContent = `$${total.toFixed(2)}`;
            document.getElementById('depositAmount').textContent = `$${deposit.toFixed(2)}`;
        }

        // تحديث ملخص المراجعة
        function updateReviewSummary() {
            document.getElementById('reviewDate').textContent = selectedDate || '-';
            document.getElementById('reviewTime').textContent = selectedTime || '-';
            document.getElementById('reviewDuration').textContent = `${selectedDuration} hours`;
            document.getElementById('reviewGuests').textContent = guestCount;

            const servicesList = document.getElementById('reviewServices');
            servicesList.innerHTML = '';

            if (selectedServices.length === 0) {
                servicesList.innerHTML = '<li class="list-group-item border-0 px-0">No additional services</li>';
            } else {
                selectedServices.forEach(service => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item border-0 px-0 d-flex justify-content-between';
                    li.innerHTML = `
                    <span>${service.name}</span>
                    <span class="fw-bold">$${service.price}</span>
                `;
                    servicesList.appendChild(li);
                });
            }
        }

        // التنقل بين الأشهر
        function prevMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar();
        }

        // إرسال الحجز
        function submitBooking() {
            if (!selectedDate || !selectedTime) {
                alert('Please select date and time');
                return;
            }

            if (!document.getElementById('terms').checked) {
                alert('Please accept the terms and conditions');
                return;
            }

            // إظهار نموذج التأكيد
            $('#confirmationModal').modal('show');
        }

        // التهيئة
        document.addEventListener('DOMContentLoaded', function() {
            generateCalendar();
            goToStep(1);

            // تحديث الحسابات عند تغيير المدخلات
            document.getElementById('guestCount').addEventListener('change', function() {
                guestCount = parseInt(this.value);
                updateCalculations();
            });
        });
    </script>
@endsection

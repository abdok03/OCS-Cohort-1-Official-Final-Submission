<div>
    <style>
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
            cursor: pointer;
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

        .summary-card {
            position: sticky;
            top: 100px;
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #eee;
        }

        /* Video Hover Styles for Services */
        .service-video-wrapper {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.3s ease;
            background: black;
            z-index: 1;
            pointer-events: none;
        }

        .service-option:hover .service-video-wrapper {
            opacity: 1;
        }

        .service-video-hint {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.5rem;
            opacity: 0.7;
            pointer-events: none;
            z-index: 2;
        }

        .service-option:hover .service-video-hint {
            display: none;
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
        @if (session()->has('booking_success'))
            <div class="alert alert-success text-center mb-4 p-5">
                <div class="checkmark-circle mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h4>{{ session('booking_success')['message'] }}</h4>
                <p>Reference: {{ session('booking_success')['reference'] }}</p>
                <div class="mt-4">
                    <a href="{{ route('user.bookings') }}" class="btn btn-primary">My Bookings</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">Home</a>
                </div>
            </div>
        @else
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4 p-lg-5">
                            <!-- Stepper -->
                            <div class="stepper">
                                <div class="step {{ $currentStep == 1 ? 'active' : ($currentStep > 1 ? 'completed' : '') }}"
                                    wire:click="goToStep(1)">
                                    <div class="number">1</div>
                                    <span>Select Date & Time</span>
                                </div>
                                <div class="step {{ $currentStep == 2 ? 'active' : ($currentStep > 2 ? 'completed' : '') }}"
                                    wire:click="goToStep(2)">
                                    <div class="number">2</div>
                                    <span>Add Services</span>
                                </div>
                                <div class="step {{ $currentStep == 3 ? 'active' : '' }}" wire:click="goToStep(3)">
                                    <div class="number">3</div>
                                    <span>Review & Pay</span>
                                </div>
                            </div>

                            <!-- Error Message -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Step 1 -->
                            @if ($currentStep == 1)
                                <div>
                                    <h3 class="fw-bold mb-4">Select Your Event Date & Time</h3>

                                    <!-- Calendar -->
                                    <div class="mb-5">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="fw-bold mb-0">{{ $this->currentMonthName }}</h5>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary" wire:click="prevMonth">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary" wire:click="nextMonth">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="date-picker">
                                            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                                <div class="fw-bold text-muted">{{ $day }}</div>
                                            @endforeach

                                            <!-- Empty slots for start of month -->
                                            @php
                                                $firstDay = \Carbon\Carbon::create($currentYear, $currentMonth, 1)
                                                    ->dayOfWeek;
                                            @endphp
                                            @for ($i = 0; $i < $firstDay; $i++)
                                                <div></div>
                                            @endfor

                                            <!-- Days -->
                                            @foreach ($days as $index => $day)
                                                <div wire:key="day-{{ $index }}" class="date-day {{ $day['is_past'] || $day['is_booked'] ? 'unavailable' : '' }} {{ $day['is_selected'] ? 'selected' : '' }}"
                                                    @if (!$day['is_past'] && !$day['is_booked']) wire:click="selectDate('{{ $day['day'] }}')" @endif>
                                                    {{ $day['day'] }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Time Selection -->
                                    @if ($selectedDate)
                                        <div class="mb-4">
                                            <h5 class="mb-3">Select Time Slot</h5>
                                            <div class="row">
                                                @foreach ($availableTimes as $time)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="time-slot {{ $selectedTime == $time ? 'selected' : '' }}"
                                                            wire:click="selectTime('{{ $time }}')">
                                                            {{ $time }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Duration -->
                                    <div class="mb-5">
                                        <h5 class="mb-3">Event Duration</h5>
                                        <div class="row g-3">
                                            @foreach ($durationOptions as $option)
                                                <div class="col-md-3">
                                                    <div class="time-slot {{ $duration == $option ? 'selected' : '' }}"
                                                        wire:click="selectDuration({{ $option }})">
                                                        {{ $option }} hours
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Guests -->
                                    <div class="mb-5">
                                        <h5 class="mb-3">Number of Guests</h5>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" wire:click="updateGuests(-10)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" class="form-control text-center"
                                                wire:model.live="guests" readonly>
                                            <button class="btn btn-outline-secondary" wire:click="updateGuests(10)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted">Max capacity: {{ $hall->capacity_max }}
                                            guests</small>

                                        <!-- Mixed Event Toggle -->
                                        <div class="form-check form-switch mt-4 p-3 border rounded">
                                            <input class="form-check-input" type="checkbox" id="mixedEventSwitch" wire:model="isMixed">
                                            <label class="form-check-label ms-2 fw-semibold" for="mixedEventSwitch">
                                                <i class="fas fa-venus-mars me-2" style="color: var(--primary-gold);"></i>
                                                Mixed Event (Co-ed)
                                            </label>
                                            <div class="small text-muted mt-1 ps-2">Check this if the event will have mixed gender attendance.</div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary" wire:click="goToStep(2)">
                                            Continue to Services <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Step 2 -->
                            @if ($currentStep == 2)
                                <div>
                                    <h3 class="fw-bold mb-4">Enhance Your Experience</h3>
                                    
                                    <h5 class="fw-bold mb-3">Extra Services</h5>
                                    <div class="services-list">
                                        @foreach ($dynamicServices as $service)
                                            <div class="service-option p-0 overflow-hidden {{ $this->isServiceSelected($service->id) ? 'selected shadow-sm' : '' }}"
                                                wire:click="toggleService({{ $service->id }})">
                                                <div class="row g-0">
                                                    <div class="col-md-4 position-relative">
                                                        @if($service->image_path)
                                                            <img src="{{ asset('storage/' . $service->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 120px;">
                                                        @else
                                                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center" style="min-height: 120px;">
                                                                <i class="bi bi-star-fill text-muted opacity-25"></i>
                                                            </div>
                                                        @endif
                                                        @if($service->video_path)
                                                            <div class="service-video-hint">
                                                                <i class="fas fa-play-circle"></i>
                                                            </div>
                                                            <div class="service-video-wrapper">
                                                                <video class="w-100 h-100 object-fit-cover service-hover-video" playsinline loop>
                                                                    <source src="{{ asset('storage/' . $service->video_path) }}" type="video/mp4">
                                                                </video>
                                                            </div>
                                                            <div class="position-absolute bottom-0 start-0 m-2 z-index-10">
                                                                <button type="button" class="btn btn-xs btn-primary rounded-pill px-2 py-0 shadow-lg" 
                                                                    onclick="event.stopPropagation(); playServiceVideo('{{ asset('storage/' . $service->video_path) }}')"
                                                                    style="font-size: 0.65rem;">
                                                                    Full Preview
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8 p-3">
                                                        <div class="d-flex align-items-center mb-1">
                                                            <span class="service-checkbox"></span>
                                                            <h6 class="fw-bold mb-0">{{ $service->name }}</h6>
                                                        </div>
                                                        <p class="text-muted small mb-2">{{ Str::limit($service->description, 80) }}</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="fw-bold text-primary">${{ number_format($service->price, 2) }}</span>
                                                            <span class="badge bg-light text-muted fw-normal">{{ ucfirst($service->category) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mb-5 mt-4">
                                        <h5 class="mb-3">Special Requests</h5>
                                        <textarea class="form-control" wire:model="specialRequests" rows="4" placeholder="Any special requirements..."></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-outline-secondary" wire:click="goToStep(1)">
                                            <i class="fas fa-arrow-left me-2"></i> Back
                                        </button>
                                        <button class="btn btn-primary" wire:click="goToStep(3)">
                                            Review & Continue <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <!-- Step 3 -->
                            @if ($currentStep == 3)
                                <div>
                                    <h3 class="fw-bold mb-4">Review Your Booking</h3>

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
                                                        <td>{{ $selectedDate }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Time:</strong></td>
                                                        <td>{{ $selectedTime }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Guests:</strong></td>
                                                        <td>{{ $guests }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="fw-bold mb-3">Selected Services</h5>
                                                <ul class="list-group">
                                                    @forelse($this->getSelectedServicesDetails() as $service)
                                                         <li
                                                             class="list-group-item border-0 px-0 d-flex justify-content-between">
                                                             <span>{{ $service->name }}</span>
                                                             <span class="fw-bold">${{ number_format($service->price, 2) }}</span>
                                                         </li>
                                                     @empty
                                                        <li class="list-group-item border-0 px-0">No additional
                                                            services
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Info Note -->
                                    <div class="alert alert-info mb-5">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Please note: No payment is required at this stage. Once your booking request is approved by the admin, you will be notified to proceed with the payment.
                                    </div>

                                    <div class="mb-5">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="agreeTerms">
                                            <label class="form-check-label">
                                                I agree to the Terms & Conditions
                                            </label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-outline-secondary" wire:click="goToStep(2)">
                                            Back
                                        </button>
                                        <button class="btn btn-primary btn-lg px-5" wire:click="submitBooking"
                                            wire:loading.attr="disabled">
                                            <span wire:loading.remove>Submit Booking Request</span>
                                            <span wire:loading>Processing...</span>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Summary -->
                <div class="col-lg-4">
                    <div class="summary-card">
                        <div class="d-flex align-items-center mb-4">
                            @if ($hall->images->count() > 0)
                                <img src="{{ asset('storage/' . $hall->images->first()->image_path) }}"
                                    class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                            @endif
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1">{{ $hall->name }}</h6>
                                <small class="text-muted">{{ $hall->city }}</small>
                            </div>
                        </div>

                        <div class="price-breakdown">
                            <div class="price-row d-flex justify-content-between mb-2">
                                <span>Venue Rental ({{ $duration }}h)</span>
                                <span>${{ number_format($calculations['venue_price'], 2) }}</span>
                            </div>
                            <div class="price-row d-flex justify-content-between mb-2">
                                <span>Additional Services</span>
                                <span>${{ number_format($calculations['services_price'], 2) }}</span>
                            </div>
                            <div class="price-row d-flex justify-content-between mb-2">
                                <span>Service Fee (10%)</span>
                                <span>${{ number_format($calculations['service_fee'], 2) }}</span>
                            </div>
                            <div class="price-row d-flex justify-content-between mb-2">
                                <span>Taxes (8%)</span>
                                <span>${{ number_format($calculations['taxes'], 2) }}</span>
                            </div>
                            <div class="price-row total d-flex justify-content-between mt-3 pt-3 border-top fw-bold">
                                <span>Total</span>
                                <span>${{ number_format($calculations['total'], 2) }}</span>
                            </div>
                            <div class="price-row d-flex justify-content-between mt-2">
                                <small class="text-muted">Deposit (25%)</small>
                                <small class="text-muted">${{ number_format($calculations['deposit'], 2) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    <!-- Video Modal for User View -->
    <div class="modal fade" id="userVideoModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden bg-black">
                <div class="modal-header border-0 position-absolute top-0 end-0 z-index-10 p-3">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <video id="userPreviewVideo" class="w-100" controls>
                        <source src="" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>

    <script>
        function playServiceVideo(url) {
            const modal = new bootstrap.Modal(document.getElementById('userVideoModal'));
            const player = document.getElementById('userPreviewVideo');
            player.querySelector('source').src = url;
            player.load();
            modal.show();
        }

        document.getElementById('userVideoModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('userPreviewVideo').pause();
        });

        // Hover Video Logic for services
        function initServiceHoverVideos() {
            document.querySelectorAll('.service-option').forEach(card => {
                const video = card.querySelector('.service-hover-video');
                if (video) {
                    card.addEventListener('mouseenter', () => {
                        video.muted = false;
                        video.play().catch(e => {
                            video.muted = true;
                            video.play();
                        });
                    });
                    card.addEventListener('mouseleave', () => {
                        video.pause();
                        video.currentTime = 0;
                    });
                }
            });
        }

        // Run on initial load
        initServiceHoverVideos();

        // Run whenever Livewire updates (since services might be filtered or steps changed)
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('step-changed', () => {
                setTimeout(initServiceHoverVideos, 100);
            });
        });
    </script>
</div>

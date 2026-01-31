@extends('layouts.user')

@section('title', 'Secure Checkout - Royal Collection')

@section('content')
<div class="py-5" style="background: var(--ivory-white); min-height: 100vh;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="premium-card p-0 shadow-lg border-0 overflow-hidden">
                    <div class="row g-0">
                        <!-- Left Side: Booking Summary -->
                        <div class="col-lg-5 text-white p-5 d-flex flex-column justify-content-between" style="background: var(--midnight);">
                            <div>
                                <span class="text-uppercase tracking-widest small fw-bold text-muted mb-4 d-block">Reservation Finalization</span>
                                <h1 class="luxury-text display-5 mb-4">Confirm Your <br><span class="text-gold">Celebration</span></h1>
                                
                                <div class="p-4 rounded-4 mb-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(212, 175, 55, 0.2);">
                                    <h5 class="text-gold mb-3">{{ $booking->hall->name }}</h5>
                                    <div class="d-flex flex-column gap-2 small opacity-75">
                                        <div class="d-flex gap-2"><i class="bi bi-calendar-check text-gold"></i> {{ $booking->event_date->format('l, F d, Y') }}</div>
                                        <div class="d-flex gap-2"><i class="bi bi-clock text-gold"></i> {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }} onwards</div>
                                        <div class="d-flex gap-2"><i class="bi bi-people text-gold"></i> Guest list: {{ $booking->guests }} invitations</div>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="opacity-50">Venue Rental</span>
                                        <span>${{ number_format($booking->total_price * 0.9, 0) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-4">
                                        <span class="opacity-50">Concierge Services</span>
                                        <span>${{ number_format($booking->total_price * 0.1, 0) }}</span>
                                    </div>
                                    <div style="height: 1px; background: rgba(255,255,255,0.1);" class="mb-4"></div>
                                    <div class="d-flex justify-content-between align-items-end">
                                        <span class="fs-5">Grand Total</span>
                                        <span class="fs-1 fw-bold text-gold">${{ number_format($booking->total_price, 0) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-5 opacity-50 small">
                                <p><i class="bi bi-shield-lock me-2"></i> All transactions are secured with 256-bit SSL encryption.</p>
                            </div>
                        </div>

                        <!-- Right Side: Secure Payment -->
                        <div class="col-lg-7 bg-white p-5">
                            <div class="d-flex justify-content-between align-items-center mb-5">
                                <h2 class="luxury-text h3 mb-0">Secure Payment</h2>
                                <div class="d-flex gap-3">
                                    <i class="bi bi-credit-card fs-3 text-muted"></i>
                                    <i class="bi bi-apple fs-3 text-muted"></i>
                                </div>
                            </div>

                            <form action="{{ route('bookings.process-payment', $booking->id) }}" method="POST" id="payment-form">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Legal Cardholder Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-4 border-light bg-light px-4" name="card_name" placeholder="Full name as on card" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Credit or Debit Card</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0 rounded-start-4 px-3"><i class="bi bi-credit-card-2-front"></i></span>
                                        <input type="text" class="form-control form-control-lg border-0 bg-light px-2" name="card_number" placeholder="0000 0000 0000 0000" style="border-radius: 0 16px 16px 0 !important;" required>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-6 mb-4 mb-md-0">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Expiry Date</label>
                                        <input type="text" class="form-control form-control-lg rounded-4 border-light bg-light px-4" name="card_expiry" placeholder="MM / YY" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Security Code (CVV)</label>
                                        <input type="password" class="form-control form-control-lg rounded-4 border-light bg-light px-4" name="card_cvv" placeholder="•••" required>
                                    </div>
                                </div>

                                <div class="p-4 rounded-4 bg-light mb-5">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" checked required>
                                        <label class="form-check-label small text-muted" for="terms">
                                            I agree to the <a href="#" class="text-gold fw-bold text-decoration-none">Terms of Service</a> and Cancellation Policy for this venue.
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn-royal w-100 py-3 fs-5 rounded-4 shadow-sm" id="submit-button">
                                    Finalize Reservation
                                </button>
                                
                                <div class="text-center mt-4">
                                    <a href="{{ route('user.bookings') }}" class="text-decoration-none text-muted small hover-gold">
                                        <i class="bi bi-arrow-left me-1"></i> Back to concierge
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-gold { color: var(--royal-gold) !important; }
    .hover-gold:hover { color: var(--royal-gold) !important; }
    #payment-form .form-control:focus {
        background: #fff !important;
        border: 1px solid var(--royal-gold) !important;
        box-shadow: 0 0 15px rgba(212, 175, 55, 0.1);
    }
</style>

<script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        const btn = document.getElementById('submit-button');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing Payment...';
    });
</script>
@endsection

@extends('layouts.venue')

@section('title', 'Owner Preview: ' . $hall->name)

@section('content')
<div class="container py-4">
    <!-- Header with Quick Stats -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small">
                        <li class="breadcrumb-item"><a href="{{ route('venue.halls.index') }}" class="text-decoration-none text-muted">My Halls</a></li>
                        <li class="breadcrumb-item active fw-bold text-primary">Preview</li>
                    </ol>
                </nav>
            </div>
            <h2 class="fw-bold text-dark mb-0">{{ $hall->name }} <span class="badge {{ $hall->status ? 'bg-soft-success text-success' : 'bg-soft-secondary text-secondary' }} fs-6 ms-2 rounded-pill px-3">{{ $hall->status ? 'Active' : 'Draft' }}</span></h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('venue.halls.services', $hall->id) }}" class="btn btn-outline-primary px-4 rounded-pill border-0 fw-bold bg-white shadow-sm">
                <i class="bi bi-stars me-2"></i>Extra Services
            </a>
            <a href="{{ route('venue.halls.edit', $hall->id) }}" class="btn btn-white shadow-sm px-4 rounded-pill border-0 fw-bold">
                <i class="bi bi-pencil me-2"></i>Edit Details
            </a>
            <a href="{{ route('venue.details', $hall) }}" class="btn btn-primary px-4 rounded-pill shadow-gold fw-bold">
                <i class="bi bi-eye me-2"></i>Public View
            </a>
        </div>
    </div>

    <div class="row g-4 text-start" dir="ltr">
        <!-- Main Content Area -->
        <div class="col-lg-8">
            <!-- Visuals Gallery -->
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4">Venue Gallery</h5>
                <div class="row g-3">
                    @forelse($hall->images as $index => $image)
                        <div class="col-md-{{ $index === 0 ? '12' : '4' }}">
                            <div class="gallery-preview rounded-4 overflow-hidden shadow-sm position-relative">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-100 object-fit-cover" style="height: {{ $index === 0 ? '400px' : '150px' }};" alt="Venue Photo">
                                @if($image->is_primary)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-primary rounded-pill px-3 py-2 border shadow-sm"><i class="bi bi-star-fill me-1"></i> Main Photo</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center bg-light rounded-4 border-2 border-dashed">
                            <i class="bi bi-camera-fill display-3 text-muted opacity-25"></i>
                            <p class="text-muted mt-3">No images uploaded yet.</p>
                            <a href="{{ route('venue.halls.images', $hall->id) }}" class="btn btn-primary btn-sm rounded-pill px-4">Upload Photos</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Description & Facilities -->
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold mb-4">Service Description</h5>
                <div class="bg-light rounded-4 p-4 mb-4" style="line-height: 1.8; color: #475569;">
                    {!! nl2br(e($hall->description)) !!}
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="fw-bold text-uppercase small text-muted mb-3">Categories</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($hall->categories as $category)
                                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <!-- Pricing Summary -->
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4 border-top border-primary border-4">
                <h6 class="fw-bold text-muted text-uppercase small mb-4">Listing Status</h6>
                <div class="vstack gap-3 mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Hourly Rate</span>
                        <span class="fw-bold text-dark fs-5">${{ number_format($hall->price_per_hour, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Daily Rate</span>
                        <span class="fw-bold text-dark fs-5">${{ number_format($hall->price_per_day, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="text-muted">Max Capacity</span>
                        <span class="fw-bold text-dark">{{ $hall->capacity_max }} guests</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">City</span>
                        <span class="fw-bold text-dark">{{ $hall->city }}</span>
                    </div>
                </div>
                <div class="alert bg-soft-info text-info border-0 rounded-4 small leading-relaxed px-3 py-3 mb-0">
                    <i class="bi bi-info-circle-fill me-2"></i> This information is visible to customers when browsing the platform.
                </div>
            </div>

            <!-- Admin Stats for this Hall -->
            <div class="premium-card bg-dark text-white shadow-lg border-0 rounded-4 p-4 mb-4">
                <h6 class="fw-bold text-white-50 text-uppercase small mb-4">Venue Statistics</h6>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-white-transparent rounded-3 text-center">
                            <div class="display-6 fw-bold mb-0">{{ $hall->bookings()->count() }}</div>
                            <div class="small opacity-75">Bookings</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-white-transparent rounded-3 text-center">
                            <div class="display-6 fw-bold mb-0">4.8</div>
                            <div class="small opacity-75">Rating</div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-top border-secondary">
                    <p class="small text-white-50 mb-0">Created on: <strong>{{ $hall->created_at->format('M d, Y') }}</strong></p>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 border-top border-danger border-4">
                <h6 class="fw-bold text-danger text-uppercase small mb-3">Management Action</h6>
                <p class="small text-muted mb-4 text-start">Deactivating or deleting this venue will cancel all future bookings and remove it from public search.</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-secondary rounded-pill fw-bold py-2">Deactivate Venue</button>
                    <form action="{{ route('venue.halls.delete', $hall->id) }}" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to PERMANENTLY delete this venue? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold py-2">Delete Permanently</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-primary { background-color: rgba(212, 175, 55, 0.1); }
    .bg-soft-info { background-color: rgba(13, 202, 240, 0.1); }
    .bg-soft-secondary { background-color: rgba(108, 117, 125, 0.1); }
    .bg-white-transparent { background-color: rgba(255, 255, 255, 0.1); }
    .shadow-gold { box-shadow: 0 4px 14px 0 rgba(212, 175, 55, 0.39); }
    .btn-white { background-color: white; color: #1e293b; }
    .object-fit-cover { object-fit: cover; }
    .leading-relaxed { line-height: 1.6; }
</style>
@endsection

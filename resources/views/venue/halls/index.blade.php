@extends('layouts.venue')

@section('title', 'My Halls')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-dark mb-1">My Venues</h2>
            <p class="text-muted mb-0">Manage your property listings and their configuration.</p>
        </div>
        <a href="{{ route('venue.halls.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Add New Venue
        </a>
    </div>

    <!-- Inventory Stats -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="premium-card p-4 bg-white shadow-sm border-0 d-flex align-items-center">
                <div class="icon-box bg-primary-light text-primary rounded-4 p-3 me-3">
                    <i class="bi bi-building fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Total Venues</h6>
                    <h3 class="fw-bold mb-0">{{ $halls->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="premium-card p-4 bg-white shadow-sm border-0 d-flex align-items-center">
                <div class="icon-box bg-success-light text-success rounded-4 p-3 me-3">
                    <i class="bi bi-check-circle fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Active Listings</h6>
                    <h3 class="fw-bold mb-0 text-success">{{ $halls->where('status', 1)->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="premium-card p-4 bg-white shadow-sm border-0 d-flex align-items-center">
                <div class="icon-box bg-info-light text-info rounded-4 p-3 me-3">
                    <i class="bi bi-star-fill fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Total Capacity</h6>
                    <h3 class="fw-bold mb-0 text-info">{{ number_format($halls->sum('capacity_max')) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Halls Grid/Table -->
    <div class="premium-card bg-white shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-subtle text-muted small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-4 border-0 py-4">Venue Details</th>
                        <th class="border-0 py-4">Location</th>
                        <th class="border-0 py-4">Capacity</th>
                        <th class="border-0 py-4">Pricing</th>
                        <th class="border-0 py-4 text-center">Status</th>
                        <th class="pe-4 border-0 py-4 text-end">Operations</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($halls as $hall)
                        <tr>
                            <td class="ps-4 py-4">
                                <div class="d-flex align-items-center">
                                    <div class="venue-image-wrapper rounded-3 me-3 overflow-hidden shadow-sm" style="width: 70px; height: 50px;">
                                        @if($hall->primaryImage)
                                            <img src="{{ asset('storage/' . $hall->primaryImage->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Venue">
                                        @else
                                            <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted small">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark fs-6">{{ $hall->name }}</div>
                                        <div class="small text-muted">ID: {{ strtoupper(substr($hall->slug, 0, 8)) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ $hall->city }}</div>
                                <div class="small text-muted">{{ Str::limit($hall->address, 25) }}</div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ $hall->capacity_max }} guests</div>
                                <div class="small text-muted">Min: {{ $hall->capacity_min }}</div>
                            </td>
                            <td>
                                <div class="small fw-bold text-primary">${{ number_format($hall->price_per_hour) }}<span class="text-muted fw-normal" style="font-size: 0.7rem;">/hr</span></div>
                                <div class="small text-muted">${{ number_format($hall->price_per_day) }}<span class="text-muted fw-normal" style="font-size: 0.7rem;">/day</span></div>
                            </td>
                            <td class="text-center">
                                @if($hall->status)
                                    <span class="badge rounded-pill bg-soft-success text-success px-3 border border-success-subtle">LIVE</span>
                                @else
                                    <span class="badge rounded-pill bg-soft-secondary text-secondary px-3">DRAFT</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-light rounded-circle shadow-none" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2 rounded-3 mt-1">
                                        <li><a class="dropdown-item rounded-2" href="{{ route('venue.halls.preview', $hall->id) }}"><i class="bi bi-box-arrow-right me-2"></i>Review & Manage</a></li>
                                        <li><a class="dropdown-item rounded-2" href="{{ route('venue.halls.edit', $hall->id) }}"><i class="bi bi-pencil me-2"></i>Edit Details</a></li>
                                        <li><a class="dropdown-item rounded-2" href="{{ route('venue.halls.images', $hall->id) }}"><i class="bi bi-images me-2"></i>Manage Gallery</a></li>
                                        <li><a class="dropdown-item rounded-2" href="{{ route('venue.halls.services', $hall->id) }}"><i class="bi bi-star me-2"></i>Extra Services</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item rounded-2 text-danger" href="#"><i class="bi bi-trash me-2"></i>Deactivate</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-5">
                                    <img src="{{ asset('img/empty-halls.svg') }}" alt="Empty" class="mb-4 opacity-25" style="width: 150px;">
                                    <h5 class="text-dark fw-bold">No halls listed yet</h5>
                                    <p class="text-muted mb-4">You haven't added any properties to your management dashboard.</p>
                                    <a href="{{ route('venue.halls.create') }}" class="btn btn-primary px-5 rounded-pill shadow-sm">Get Started</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white border-0 py-4 px-4">
            {{ $halls->links() }}
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; transition: transform 0.2s ease; }
    .bg-primary-light { background-color: rgba(212, 175, 55, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    
    .bg-soft-success { background-color: rgba(25, 135, 84, 0.1); }
    .bg-soft-secondary { background-color: rgba(108, 117, 125, 0.1); }

    .btn-icon { width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; }
    .venue-image-wrapper img { transition: transform 0.3s ease; }
    .venue-image-wrapper:hover img { transform: scale(1.1); }
    
    .table thead th { letter-spacing: 0.05em; font-size: 0.75rem; }
    .object-fit-cover { object-fit: cover; }
    
    .dropdown-item { font-size: 0.875rem; padding: 0.6rem 1rem; }
    .dropdown-item:hover { background-color: #f8fafc; color: var(--primary); }
</style>
@endsection

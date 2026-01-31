<!-- resources/views/pages/listings.blade.php -->
{{-- {{ dd($categories) }} --}}

@extends('layouts.admin')

@section('title', 'Listings Management')

@section('content')


    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1">Venue Management</h1>
                    <p class="text-muted mb-0">Manage wedding and engagement halls</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-funnel me-2"></i> Filter & Sort
                        </button>
                        <div class="dropdown-menu p-3" style="width: 300px;">
                            <form action="{{ route('halls.index') }}" method="GET">
                                <div class="mb-3">
                                    <label class="form-label">Category</label>
                                    <select name="category" class="form-select">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ request('category') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                @if (request()->anyFilled(['category', 'status']))
                                    <a href="{{ route('halls.index') }}"
                                        class="btn btn-link btn-sm w-100 mt-2 text-decoration-none">Clear All</a>
                                @endif
                            </form>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createListingModal">
                            <i class="bi bi-plus-lg me-2"></i> Add New Hall
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Listings</div>
                            <div class="stat-value">{{ $totalHalls }}</div>
                            <div class="stat-trend trend-up">
                                <i class="bi bi-arrow-up-right"></i>
                                <span>+12.5%</span>
                            </div>
                        </div>
                        <div class="stat-icon primary">
                            <i class="bi bi-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Active</div>
                            <div class="stat-value">{{ $activeHalls }}</div>
                            <div class="stat-trend trend-up">
                                <i class="bi bi-arrow-up-right"></i>
                                <span>+8.3%</span>
                            </div>
                        </div>
                        <div class="stat-icon success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Pending Review</div>
                            <div class="stat-value">{{ $pendingHalls }}</div>
                            <div class="stat-trend trend-down">
                                <i class="bi bi-arrow-down-right"></i>
                                <span>-5.2%</span>
                            </div>
                        </div>
                        <div class="stat-icon warning">
                            <i class="bi bi-clock"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="stat-label">Total Value</div>
                            <div class="stat-value">{{ $totalValue }}</div>
                            <div class="stat-trend trend-up">
                                <i class="bi bi-arrow-up-right"></i>
                                <span>+15.7%</span>
                            </div>
                        </div>
                        <div class="stat-icon danger">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Listings Grid -->
        <div class="row g-3">
            @foreach ($halls as $hall)
                <div class="col-xl-4 col-lg-6">
                    <div class="card listing-card">
                        <div class="card-img-top position-relative">
                            <img src="{{ $hall->primaryImage
                                ? asset('storage/' . $hall->primaryImage->image_path)
                                : 'https://via.placeholder.com/600x400' }}"
                                class="img-fluid" alt="{{ $hall->name }}" style="height: 200px; object-fit: cover;">



                            <div class="listing-badges">
                                @foreach ($hall->categories as $category)
                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                @endforeach
                                <span class="badge {{ $hall->status ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $hall->status ? 'Active' : 'Inactive' }}
                                </span>

                            </div>
                            <div class="listing-price">
                                ${{ number_format($hall->price_per_hour, 0) }}/hour
                            </div>

                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-2">{{ $hall->name }}</h5>
                            <p class="card-text text-muted mb-3">
                                <i class="bi bi-geo-alt me-1"></i> {{ $hall->address }} - {{ $hall->city }}

                            </p>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Capacity</small>
                                    <div class="fw-medium">{{ $hall->capacity_min }} - {{ $hall->capacity_max }} guests
                                    </div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Views</small>
                                    <div class="fw-medium">{{ $hall->views ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="rating">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <span class="fw-medium">{{ $hall->rating ?? 0 }}</span>
                                    <small class="text-muted">({{ $hall->reviews ?? 0 }} reviews)</small>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('halls.edit', $hall) }}" class="btn btn-sm btn-outline-primary"
                                        title="Edit Hall">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- زر عرض القاعة -->
                                    <a href="{{ route('halls.show', $hall) }}" class="btn btn-sm btn-outline-secondary"
                                        title="View Hall">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form method="POST" action="{{ route('halls.destroy', $hall) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-action text-danger"
                                            onclick="return confirm('هل أنت متأكد من حذف هذه القاعة؟')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $halls->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

            <div class="modal fade" id="createListingModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Wedding Hall</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="createListingForm" method="POST" action="{{ route('halls.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Hall Name</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Enter hall name" required>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Category</label>
                                        <select name="categories[]" class="form-select" multiple required>
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price per Day</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" name="price_per_day" class="form-control"
                                                placeholder="0.00" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Price per Hour</label>
                                        <input type="number" name="price_per_hour" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Min Capacity</label>
                                        <input type="number" name="capacity_min" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Max Capacity</label>
                                        <input type="number" name="capacity_max" class="form-control" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">City</label>
                                        <input type="text" name="city" class="form-control" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>

                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" rows="3" placeholder="Describe the hall..."></textarea>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Upload Images</label>
                                        <input type="file" name="images[]" class="form-control" multiple
                                            accept="image/*">

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        Create Listing
                                    </button>
                                </div>
                                @error('field_name')
                                @enderror
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        @endsection

        @section('scripts')
            <script>
                //             function showCreateListingModal() {
                //                 // Create modal HTML
                //                 const modalHTML = `
    //         <div class="modal fade" id="createListingModal" tabindex="-1">
    //             <div class="modal-dialog modal-lg">
    //                 <div class="modal-content">
    //                     <div class="modal-header">
    //                         <h5 class="modal-title">Add New Wedding Hall</h5>
    //                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    //                     </div>
    //                     <div class="modal-body">
    //                         <form id="createListingForm" method="POST"
    //       action="{{ route('halls.store') }}"
    //       enctype="multipart/form-data">
    //                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
    //                             <div class="row">
    //                                 <div class="col-12 mb-3">
    //                                     <label class="form-label">Hall Name</label>
    //                                     <input type="text" name="name" class="form-control" placeholder="Enter hall name" required>
    //                                 </div>
    //                                 <div class="col-md-6 mb-3">
    //                                     <label class="form-label">Category</label>
    //                                    <select name="categories[]" class="form-select" multiple  required>
    //     <option value="">Select Category</option>
    //     @foreach ($categories as $category)
    //         <option value="{{ $category->id }}">{{ $category->name }}</option>
    //     @endforeach
    // </select>

    //                                 </div>
    //                                 <div class="col-md-6 mb-3">
    //                                     <label class="form-label">Price per Day</label>
    //                                     <div class="input-group">
    //                                         <span class="input-group-text">$</span>
    //                                         <input type="number" name="price_per_day" class="form-control" placeholder="0.00" required>
    //                                     </div>
    //                                 </div>
    //                                 <div class="col-md-6 mb-3">
    //     <label class="form-label">Price per Hour</label>
    //     <input type="number" name="price_per_hour" class="form-control" required>
    // </div>

    //                               <div class="col-md-6 mb-3">
    //     <label class="form-label">Min Capacity</label>
    //     <input type="number" name="capacity_min" class="form-control" required>
    // </div>

    // <div class="col-md-6 mb-3">
    //     <label class="form-label">Max Capacity</label>
    //     <input type="number" name="capacity_max" class="form-control" required>
    // </div>
    // <div class="col-12 mb-3">
    //     <label class="form-label">Address</label>
    //     <input type="text" name="address" class="form-control" required>
    // </div>

    // <div class="col-md-6 mb-3">
    //     <label class="form-label">City</label>
    //     <input type="text" name="city" class="form-control" required>
    // </div>

    //                                 <div class="col-md-6 mb-3">
    //                                     <label class="form-label">Status</label>
    //                                     <select name="status" class="form-select" required>
    //     <option value="1">Active</option>
    //     <option value="0">Inactive</option>
    // </select>

    //                                 </div>
    //                                 <div class="col-12 mb-3">
    //                                     <label class="form-label">Description</label>
    //                                     <textarea name="description" class="form-control" rows="3" placeholder="Describe the hall..."></textarea>
    //                                 </div>
    //                                 <div class="col-12 mb-3">
    //                                     <label class="form-label">Upload Images</label>
    //                                    <input type="file"
    //        name="images[]"
    //        class="form-control"
    //        multiple
    //        accept="image/*">

    //                                 </div>
    //                             </div>
    //                              <div class="modal-footer">
    //                         <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
    // <button type="submit" class="btn btn-primary">
    //     Create Listing
    // </button>
    //                     </div>
    //                         </form>
    //                     </div>

    //                 </div>
    //             </div>
    //         </div>
    //     `;

                // Remove existing modal
                // const existingModal = document.getElementById('createListingModal');
                // if (existingModal) existingModal.remove();

                // // Add new modal
                // document.body.insertAdjacentHTML('beforeend', modalHTML);

                // // Show modal
                // const modal = new bootstrap.Modal(document.getElementById('createListingModal'));
                // modal.show();
                // }

                // function createListing() {
                //     const form = document.getElementById('createListingForm');
                //     if (form.checkValidity()) {
                //         showToast('Venue created successfully', 'success');
                //         const modal = bootstrap.Modal.getInstance(document.getElementById('createListingModal'));
                //         modal.hide();
                //     } else {
                //         form.reportValidity();
                //     }
                // }
            </script>

            <style>
                .listing-card {
                    border: none;
                    box-shadow: var(--shadow);
                    transition: var(--transition);
                    height: 100%;
                }

                .listing-card:hover {
                    transform: translateY(-4px);
                    box-shadow: var(--shadow-lg);
                }

                .listing-badges {
                    position: absolute;
                    top: 1rem;
                    left: 1rem;
                    display: flex;
                    gap: 0.5rem;
                }

                .listing-price {
                    position: absolute;
                    top: 1rem;
                    right: 1rem;
                    background: rgba(255, 255, 255, 0.95);
                    padding: 0.5rem 1rem;
                    border-radius: 50px;
                    font-weight: 700;
                    color: var(--primary);
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                }

                .dark-mode .listing-price {
                    background: rgba(30, 41, 59, 0.95);
                    color: white;
                }
            </style>
        @endsection

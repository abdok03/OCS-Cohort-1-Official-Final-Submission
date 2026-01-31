@extends('layouts.venue')

@section('title', 'Edit Hall: ' . $hall->name)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb & Title -->
    <nav class="mb-4">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item small"><a href="{{ route('venue.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item small"><a href="{{ route('venue.halls.index') }}" class="text-decoration-none text-muted">My Halls</a></li>
            <li class="breadcrumb-item small active fw-bold text-primary">Edit Hall</li>
        </ol>
        <h2 class="fw-bold text-dark">Edit Venue: {{ $hall->name }}</h2>
    </nav>

    <form action="{{ route('venue.halls.update', $hall->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row g-4">
            <!-- Left Column: Basic Info -->
            <div class="col-lg-8">
                <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <span class="bg-primary-light text-primary rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">1</span>
                        General Information
                    </h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Venue Name</label>
                        <input type="text" name="name" class="form-control rounded-3 py-3 px-4 border-light bg-light" value="{{ old('name', $hall->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Detailed Description</label>
                        <textarea name="description" class="form-control rounded-3 py-3 px-4 border-light bg-light" rows="6" required>{{ old('description', $hall->description) }}</textarea>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Min Capacity</label>
                            <div class="input-group">
                                <span class="input-group-text border-light bg-light"><i class="bi bi-person"></i></span>
                                <input type="number" name="capacity_min" class="form-control rounded-end-3 py-3 border-light bg-light" min="1" value="{{ old('capacity_min', $hall->capacity_min) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Max Capacity</label>
                            <div class="input-group">
                                <span class="input-group-text border-light bg-light"><i class="bi bi-people-fill"></i></span>
                                <input type="number" name="capacity_max" class="form-control rounded-end-3 py-3 border-light bg-light" min="1" value="{{ old('capacity_max', $hall->capacity_max) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Venue Video (Recommended First)</label>
                            <div class="upload-zone rounded-4 border-2 border-dashed p-4 text-center transition-all hover-bg-light cursor-pointer mb-3 {{ $hall->video_path ? 'd-none' : '' }}" id="videoUploadZone" onclick="document.getElementById('videoInput').click()">
                                <input type="file" name="video" id="videoInput" class="d-none" accept="video/*">
                                <i class="bi bi-play-circle fs-2 text-primary mb-2 d-block"></i>
                                <span class="small fw-bold">Click to Change Video</span>
                                <p class="x-small text-muted mb-0">(Max 20MB: MP4, MOV, QT)</p>
                            </div>
                            <div id="videoPreviewContainer" class="{{ $hall->video_path ? '' : 'd-none' }} mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small fw-bold text-muted">Video Preview:</span>
                                    <button type="button" class="btn btn-link btn-sm text-danger p-0 text-decoration-none" onclick="clearVideo()">Remove Video</button>
                                </div>
                                <div class="ratio ratio-16x9 rounded-4 overflow-hidden border shadow-sm">
                                    <video id="videoPreview" controls class="w-100 h-100 object-fit-cover">
                                        @if($hall->video_path)
                                            <source src="{{ asset('storage/' . $hall->video_path) }}" type="video/mp4">
                                        @endif
                                    </video>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-muted text-uppercase">Add More Photos</label>
                        <div class="upload-zone rounded-4 border-2 border-dashed p-4 text-center transition-all hover-bg-light cursor-pointer mb-3" id="editUploadZone">
                            <input type="file" name="images[]" id="editImagesInput" class="d-none" accept="image/*" multiple>
                            <i class="bi bi-plus-circle fs-2 text-primary mb-2 d-block"></i>
                            <span class="small fw-bold">Select Photos to Add</span>
                        </div>
                        <div id="editPreviewGrid" class="row g-2"></div>
                    </div>
                </div>

                <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                    <h5 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <span class="bg-info-light text-info rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">2</span>
                        Location & Categories
                    </h5>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">City</label>
                            <input type="text" name="city" class="form-control rounded-3 py-3 px-4 border-light bg-light" value="{{ old('city', $hall->city) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Exact Address</label>
                            <input type="text" name="address" class="form-control rounded-3 py-3 px-4 border-light bg-light" value="{{ old('address', $hall->address) }}" required>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-3">Types of Events / Categories</label>
                        <div class="row g-3">
                            @foreach($categories as $category)
                                <div class="col-md-4">
                                    <div class="category-selectable rounded-3 p-3 text-center transition-all {{ in_array($category->id, $selectedCategories) ? 'bg-primary' : 'bg-light' }}">
                                        <div class="form-check p-0 m-0">
                                            <input class="form-check-input d-none" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }}>
                                            <label class="form-check-label w-100 cursor-pointer fw-semibold small py-1 {{ in_array($category->id, $selectedCategories) ? 'text-white' : '' }}" for="cat{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Pricing & Quick Links -->
            <div class="col-lg-4">
                <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 mb-4 sticky-top" style="top: 100px;">
                    <h5 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <span class="bg-success-light text-success rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">3</span>
                        Pricing & Actions
                    </h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Price per Hour</label>
                        <div class="input-group">
                            <span class="input-group-text border-light bg-light fw-bold text-dark">$</span>
                            <input type="number" name="price_per_hour" class="form-control rounded-end-3 py-3 border-light bg-light fw-bold" step="0.01" value="{{ old('price_per_hour', $hall->price_per_hour) }}" required>
                        </div>
                        <p class="small text-muted mt-2 mb-0">Current Daily Rate: <strong>${{ number_format($hall->price_per_day) }}</strong></p>
                    </div>

                    <div class="d-grid gap-3 mb-4">
                        <a href="{{ route('venue.halls.images', $hall->id) }}" class="btn btn-outline-primary rounded-pill py-2 fw-semibold">
                            <i class="bi bi-images me-2"></i> Manage Venue Photos
                        </a>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 shadow-gold fw-bold">
                            Update Venue Details
                        </button>
                        <a href="{{ route('venue.halls.index') }}" class="btn btn-light rounded-pill py-3 fw-semibold">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .bg-primary-light { background-color: rgba(212, 175, 55, 0.1); }
    .bg-info-light { background-color: rgba(13, 202, 240, 0.1); }
    .bg-success-light { background-color: rgba(25, 135, 84, 0.1); }
    
    .shadow-gold { box-shadow: 0 4px 14px 0 rgba(212, 175, 55, 0.39); }
    
    .category-selectable { cursor: pointer; border: 1px solid transparent; }
    .category-selectable:hover { background-color: #f1f5f9; border-color: #e2e8f0; }
    
    .category-selectable.bg-primary:hover { background-color: var(--primary-dark); }
    
    .form-check-input:checked + .form-check-label { color: white !important; }
    
    .cursor-pointer { cursor: pointer; }
    .form-control:focus { background-color: white; box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15); border-color: #D4AF37; }
</style>

<script>
    const videoInput = document.getElementById('videoInput');
    const videoPreviewContainer = document.getElementById('videoPreviewContainer');
    const videoPreview = document.getElementById('videoPreview');
    const videoUploadZone = document.getElementById('videoUploadZone');

    function clearVideo() {
        videoInput.value = '';
        videoPreview.src = '';
        videoPreviewContainer.classList.add('d-none');
        videoUploadZone.classList.remove('d-none');
    }

    if (videoInput) {
        videoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    videoPreview.src = e.target.result;
                    videoPreviewContainer.classList.remove('d-none');
                    videoUploadZone.classList.add('d-none');
                    videoPreview.load();
                }
                reader.readAsDataURL(file);
            }
        });
    }

    const editImagesInput = document.getElementById('editImagesInput');
    const editUploadZone = document.getElementById('editUploadZone');
    const editPreviewGrid = document.getElementById('editPreviewGrid');

    if (editUploadZone) {
        editUploadZone.addEventListener('click', () => editImagesInput.click());
    }

    if (editImagesInput) {
        editImagesInput.addEventListener('change', function() {
            editPreviewGrid.innerHTML = '';
            if (this.files) {
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-3';
                        col.innerHTML = `
                            <div class="ratio ratio-1x1 rounded-3 overflow-hidden border shadow-sm">
                                <img src="${e.target.result}" class="object-fit-cover w-100 h-100">
                            </div>
                        `;
                        editPreviewGrid.appendChild(col);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    }

    document.querySelectorAll('.category-selectable').forEach(el => {
        el.addEventListener('click', function(e) {
            const checkbox = this.querySelector('input');
            const label = this.querySelector('label');
            
            if (e.target !== checkbox) {
                checkbox.checked = !checkbox.checked;
            }
            
            if (checkbox.checked) {
                this.classList.remove('bg-light');
                this.classList.add('bg-primary');
                label.classList.add('text-white');
            } else {
                this.classList.add('bg-light');
                this.classList.remove('bg-primary');
                label.classList.remove('text-white');
            }
        });
    });
</script>
@endsection

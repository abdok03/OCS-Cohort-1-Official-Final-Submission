@extends('layouts.venue')

@section('title', 'Manage Photos: ' . $hall->name)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb & Title -->
    <nav class="mb-4">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item small"><a href="{{ route('venue.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item small"><a href="{{ route('venue.halls.index') }}" class="text-decoration-none text-muted">My Halls</a></li>
            <li class="breadcrumb-item small active fw-bold text-primary">Manage Photos</li>
        </ol>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark">Photos for: {{ $hall->name }}</h2>
            <a href="{{ route('venue.halls.edit', $hall->id) }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Back to Details
            </a>
        </div>
    </nav>

    <div class="row g-4">
        <!-- Upload Section -->
        <div class="col-lg-4">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-4">Add New Photo</h5>
                <form action="{{ route('venue.halls.images.store', $hall->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-zone rounded-4 border-2 border-dashed p-5 text-center transition-all hover-bg-light cursor-pointer mb-4" id="uploadZone">
                        <input type="file" name="image" id="imageInput" class="d-none" accept="image/*" required>
                        <i class="bi bi-cloud-arrow-up display-4 text-primary mb-3"></i>
                        <h6 class="fw-bold text-dark mb-1">Click to Upload</h6>
                        <p class="small text-muted mb-0">PNG, JPG or JPEG (Max 5MB)</p>
                    </div>
                    <div id="previewContainer" class="mb-4 d-none">
                        <label class="small text-muted fw-bold text-uppercase mb-2">Preview</label>
                        <img id="imagePreview" src="#" class="img-fluid rounded-3 shadow-sm" alt="Preview">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-gold">
                        Upload Image
                    </button>
                </form>
            </div>
        </div>

        <!-- Gallery Section -->
        <div class="col-lg-8">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Photo Gallery</h5>
                    <span class="badge bg-light text-muted">{{ $hall->images->count() }} Images total</span>
                </div>

                <div class="row g-3">
                    @forelse($hall->images as $image)
                        <div class="col-md-6 col-xl-4">
                            <div class="gallery-item-card position-relative overflow-hidden rounded-4 shadow-sm border">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Venue Photo" style="aspect-ratio: 4/3;">
                                
                                @if($image->is_primary)
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-primary rounded-pill shadow-sm py-2 px-3">
                                            <i class="bi bi-star-fill me-1"></i> Primary
                                        </span>
                                    </div>
                                @endif

                                <div class="gallery-actions position-absolute bottom-0 start-0 end-0 p-3 bg-gradient-dark d-flex justify-content-center gap-2 transition-all opacity-0">
                                    @if(!$image->is_primary)
                                        <form action="{{ route('venue.halls.images.primary', [$hall->id, $image->id]) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-light rounded-pill shadow-sm px-3" title="Set as Primary">
                                                <i class="bi bi-star me-1"></i> Make Primary
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('venue.halls.images.delete', [$hall->id, $image->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill shadow-sm px-3">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-images display-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-3">No photos uploaded yet. High quality photos attract more customers!</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .upload-zone { border-color: #e2e8f0; }
    .upload-zone:hover { border-color: #D4AF37; background-color: #fffaf0; }
    .shadow-gold { box-shadow: 0 4px 14px 0 rgba(212, 175, 55, 0.39); }
    
    .gallery-item-card:hover .gallery-actions { opacity: 1 !important; }
    .bg-gradient-dark { background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%); }
    
    .object-fit-cover { object-fit: cover; }
    .opacity-0 { opacity: 0; }
    .cursor-pointer { cursor: pointer; }
</style>

<script>
    const uploadZone = document.getElementById('uploadZone');
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');

    uploadZone.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Drag and drop support
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, e => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    uploadZone.addEventListener('drop', e => {
        const dt = e.dataTransfer;
        const files = dt.files;
        imageInput.files = files;
        
        // Trigger change
        const event = new Event('change');
        imageInput.dispatchEvent(event);
    });
</script>
@endsection

@extends('layouts.venue')

@section('title', 'Hall Services: ' . $hall->name)

@section('content')
<div class="container py-4">
    <!-- Breadcrumb & Title -->
    <nav class="mb-4">
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item small"><a href="{{ route('venue.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
            <li class="breadcrumb-item small"><a href="{{ route('venue.halls.index') }}" class="text-decoration-none text-muted">My Halls</a></li>
            <li class="breadcrumb-item small active fw-bold text-primary">Extra Services</li>
        </ol>
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold text-dark mb-0">Manage Services for: {{ $hall->name }}</h2>
            <a href="{{ route('venue.halls.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </nav>

    <div class="row g-4">
        <!-- Service Creation Form -->
        <div class="col-lg-4">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold text-dark mb-4">Add Extra Service</h5>
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 small mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('venue.halls.services.store', $hall->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Service Name</label>
                        <input type="text" name="name" class="form-control rounded-3 border-light bg-light py-2" placeholder="e.g. Zaffa Show, Special Cake..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Category</label>
                        <select name="category" class="form-select rounded-3 border-light bg-light py-2" required>
                            @forelse($categories as $cat)
                                <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                            @empty
                                <option value="" disabled>No categories found. Add one first!</option>
                            @endforelse
                        </select>
                        <div class="mt-2 text-end">
                            <a href="{{ route('venue.service-categories.index') }}" class="small text-primary text-decoration-none fw-bold">
                                <i class="bi bi-gear me-1"></i> Manage Categories
                            </a>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Service Price ($)</label>
                        <input type="number" name="price" class="form-control rounded-3 border-light bg-light py-2" step="0.01" value="0.00" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Description</label>
                        <textarea name="description" class="form-control rounded-3 border-light bg-light py-2" rows="3" placeholder="Tell customers more about this service..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase">Representative Photo</label>
                        <input type="file" name="image" class="form-control rounded-3 border-light bg-light py-2" accept="image/*">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Video Presentation (Optional)</label>
                        <input type="file" name="video" class="form-control rounded-3 border-light bg-light py-2" accept="video/*">
                        <div class="form-text x-small">Upload a short clip of the service (Max 20MB).</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-gold">
                        Add New Service
                    </button>
                </form>
            </div>
        </div>

        <!-- Services List -->
        <div class="col-lg-8">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Available Extra Services</h5>
                    <span class="badge bg-soft-primary text-primary px-3 rounded-pill">{{ $services->count() }} Services</span>
                </div>

                <div class="row g-3">
                    @forelse($services as $service)
                        <div class="col-md-6">
                            <div class="service-card border rounded-4 overflow-hidden h-100 bg-white shadow-sm transition-all hover-translate-y">
                                <div class="position-relative">
                                    @if($service->image_path)
                                        <img src="{{ asset('storage/' . $service->image_path) }}" class="w-100 object-fit-cover" style="height: 180px;" alt="{{ $service->name }}">
                                    @else
                                        <div class="w-100 bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                            <i class="bi bi-image display-4 text-muted opacity-25"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-dark rounded-pill shadow-sm px-3 py-2 border border-secondary fw-normal">
                                            {{ ucfirst($service->category) }}
                                        </span>
                                    </div>
                                    
                                    
                                    @if($service->video_path)
                                        <div class="video-play-hint">
                                            <i class="bi bi-play-circle"></i>
                                        </div>
                                        <div class="service-video-container">
                                            <video class="w-100 h-100 object-fit-cover hover-video" playsinline loop>
                                                <source src="{{ asset('storage/' . $service->video_path) }}" type="video/mp4">
                                            </video>
                                        </div>
                                        <div class="position-absolute bottom-0 end-0 m-3 z-index-10">
                                            <button type="button" class="btn btn-primary btn-sm rounded-pill shadow-sm px-3 video-play-btn" data-video="{{ asset('storage/' . $service->video_path) }}" data-bs-toggle="modal" data-bs-target="#videoModal">
                                                <i class="bi bi-play-fill me-1"></i> Full View
                                            </button>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold text-dark mb-0 fs-5">{{ $service->name }}</h6>
                                        <span class="text-primary fw-bold fs-5">${{ number_format($service->price, 2) }}</span>
                                    </div>
                                    <p class="small text-muted mb-4">{{ Str::limit($service->description, 100) }}</p>
                                    
                                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                                        <button class="btn btn-link btn-sm text-secondary p-0 text-decoration-none">Edit</button>
                                        <form action="{{ route('venue.halls.services.delete', [$hall->id, $service->id]) }}" method="POST" onsubmit="return confirm('Remove this service?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-sm text-danger p-0 text-decoration-none">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <div class="py-5">
                                <i class="bi bi-plus-circle display-1 text-muted opacity-25"></i>
                                <h5 class="text-dark fw-bold mt-4">Start adding extra services!</h5>
                                <p class="text-muted">Offer special packages and add-ons to increase your venue's appeal.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden bg-black">
            <div class="modal-header border-0 position-absolute top-0 end-0 z-index-10 p-3">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <video id="serviceVideoPlayer" class="w-100" controls>
                    <source src="" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .shadow-gold { box-shadow: 0 4px 14px 0 rgba(212, 175, 55, 0.39); }
    .bg-soft-primary { background-color: rgba(212, 175, 55, 0.1); }
    .object-fit-cover { object-fit: cover; }
    .transition-all { transition: all 0.2s ease; }
    .hover-translate-y:hover { transform: translateY(-5px); }
    .z-index-10 { z-index: 10; }

    /* Video Hover Styles */
    .service-video-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.3s ease;
        background: black;
        z-index: 1;
    }

    .service-card:hover .service-video-container {
        opacity: 1;
    }

    .video-play-hint {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 2rem;
        opacity: 0.8;
        pointer-events: none;
        z-index: 2;
        text-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    .service-card:hover .video-play-hint {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoModal = document.getElementById('videoModal');
        const videoPlayer = document.getElementById('serviceVideoPlayer');
        const videoSource = videoPlayer.querySelector('source');

        document.querySelectorAll('.video-play-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const videoUrl = this.getAttribute('data-video');
                videoSource.src = videoUrl;
                videoPlayer.load();
                videoPlayer.play();
            });
        });

        videoModal.addEventListener('hidden.bs.modal', function() {
            videoPlayer.pause();
            videoPlayer.currentTime = 0;
        });

        // Hover to Play Logic
        document.querySelectorAll('.service-card').forEach(card => {
            const video = card.querySelector('.hover-video');
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
    });
</script>
@endsection

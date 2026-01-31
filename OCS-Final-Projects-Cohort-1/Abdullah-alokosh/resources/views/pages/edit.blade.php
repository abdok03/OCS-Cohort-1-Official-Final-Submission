@extends('layouts.admin')

@section('title', 'تعديل: ' . $hall->name)

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 mb-0">Edit Venue Listing</h2>
                    <a href="{{ route('halls.index') }}" class="btn btn-outline-secondary btn-sm">Cancel & Return</a>
                </div>

                <form action="{{ route('halls.update', $hall) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Basic Information</h5>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label class="form-label fw-bold">Hall Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $hall->name) }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="1" {{ old('status', $hall->status) == 1 ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ old('status', $hall->status) == 0 ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">City</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ old('city', $hall->city) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{ old('address', $hall->address) }}" required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Categories</label>
                                    <select name="categories[]" class="form-select" multiple>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ in_array($category->id, old('categories', $hall->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Pricing & Capacity</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">Price per Hour ($)</label>
                                    <input type="number" name="price_per_hour" class="form-control"
                                        value="{{ $hall->price_per_hour }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Price per Day ($)</label>
                                    <input type="number" name="price_per_day" class="form-control"
                                        value="{{ $hall->price_per_day }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Min Capacity</label>
                                    <input type="number" name="capacity_min" class="form-control"
                                        value="{{ $hall->capacity_min }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Max Capacity</label>
                                    <input type="number" name="capacity_max" class="form-control"
                                        value="{{ $hall->capacity_max }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="description" class="form-control" rows="5">{{ old('description', $hall->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0">Venue Gallery</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Current Images</label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach ($hall->images as $image)
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                class="rounded shadow-sm"
                                                style="width: 120px; height: 120px; object-fit: cover;">
                                            @if ($image->is_primary)
                                                <span
                                                    class="badge bg-primary position-absolute top-0 start-0 m-1">Primary</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload New Images (This will add to your gallery)</label>
                                <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                <small class="text-muted">You can select multiple images. The first one will be the primary
                                    image.</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mb-5">
                        <button type="submit" class="btn btn-primary px-5 py-2">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

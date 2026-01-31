@extends('layouts.venue')

@section('title', 'Manage Service Categories')

@section('content')
<div class="container py-4">
    <div class="mb-5">
        <h2 class="fw-bold text-dark mb-1">Service Categories</h2>
        <p class="text-muted mb-0">Define the types of extra services you offer across all your venues.</p>
    </div>

    <div class="row g-4">
        <!-- Add Category -->
        <div class="col-lg-4">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-4">Add New Category</h5>
                <form action="{{ route('venue.service-categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Category Name</label>
                        <input type="text" name="name" class="form-control rounded-3 py-3 px-4 border-light bg-light" placeholder="e.g. Zaffa, Hospitality, Lighting" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-gold">
                        Save Category
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories List -->
        <div class="col-lg-8">
            <div class="premium-card bg-white shadow-sm border-0 rounded-4 p-4">
                <h5 class="fw-bold text-dark mb-4">Active Categories</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-0 px-4 py-3 rounded-start-3">Category Name</th>
                                <th class="border-0 py-3">Created</th>
                                <th class="border-0 px-4 py-3 text-end rounded-end-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td class="px-4 fw-semibold text-dark">{{ $category->name }}</td>
                                    <td>{{ $category->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 text-end">
                                        <form action="{{ route('venue.service-categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category? Services using it might be affected.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small fw-bold">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">No categories defined yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .premium-card { border-radius: 1.25rem; }
    .shadow-gold { box-shadow: 0 4px 14px 0 rgba(212, 175, 55, 0.39); }
</style>
@endsection

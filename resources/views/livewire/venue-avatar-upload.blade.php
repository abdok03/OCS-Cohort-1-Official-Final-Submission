<div class="position-relative d-inline-block mb-4">
    <div class="position-relative">
        @if ($avatar)
            <img src="{{ $avatar->temporaryUrl() }}" 
                 alt="Avatar Preview" class="rounded-circle shadow-sm border border-5 border-white" style="width: 150px; height: 150px; object-fit: cover;">
        @else
            <img src="{{ $avatarUrl }}" 
                 alt="Avatar" class="rounded-circle shadow-sm border border-5 border-white" style="width: 150px; height: 150px; object-fit: cover;">
        @endif

        <div wire:loading wire:target="avatar" class="position-absolute top-50 start-50 translate-middle">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <label class="btn btn-primary btn-icon rounded-circle position-absolute bottom-0 end-0 shadow-lg border border-3 border-white cursor-pointer">
        <i class="bi bi-camera"></i>
        <input type="file" wire:model="avatar" class="d-none" accept="image/*">
    </label>

    @error('avatar')
        <div class="position-absolute top-100 start-50 translate-middle-x mt-2 w-100">
            <span class="badge bg-danger rounded-pill">{{ $message }}</span>
        </div>
    @enderror
</div>

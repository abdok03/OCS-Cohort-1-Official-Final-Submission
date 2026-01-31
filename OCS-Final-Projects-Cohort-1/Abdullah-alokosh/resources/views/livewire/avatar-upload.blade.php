
<div>
    <div class="text-center">
        <!-- عرض الصورة الحالية -->
        @if ($avatar)
            {{-- Preview مباشر للصورة الجديدة --}}
            <img src="{{ $avatar->temporaryUrl() }}" width="150" height="150"
                class="rounded-full mb-3 object-cover border-2 border-gray-200">
        @else
            {{-- الصورة المخزنة --}}
            <img src="{{ $avatarUrl }}" width="150" height="150"
                class="rounded-full mb-3 object-cover border-2 border-gray-200">
        @endif


        <!-- زر اختيار الصورة -->
        <div class="mb-3">
            <label for="avatarInput" class="btn btn-sm btn-primary cursor-pointer">
                <i class="fas fa-camera me-1"></i> Change Avatar
            </label>
            <input type="file" id="avatarInput" wire:model="avatar" accept="image/*" class="d-none">
        </div>

        <!-- رسائل الخطأ -->
        @error('avatar')
            <div class="alert alert-danger alert-sm mt-2">{{ $message }}</div>
        @enderror

        <!-- رسائل النجاح -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-sm mt-2">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-sm mt-2">
                {{ session('error') }}
            </div>
        @endif

        <!-- مؤشر التحميل -->
        @if ($uploading)
            <div class="mt-2">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                    <span class="visually-hidden">Uploading...</span>
                </div>
                <span class="text-muted ms-2">Uploading...</span>
            </div>
        @endif

        <!-- معلومات عن الصورة -->
        <small class="text-muted d-block mt-2">
            Max size: 1MB • JPG, PNG, GIF
        </small>
    </div>
</div>

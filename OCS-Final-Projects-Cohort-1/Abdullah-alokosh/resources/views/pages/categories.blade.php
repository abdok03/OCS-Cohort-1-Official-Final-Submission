<!-- resources/views/pages/categories.blade.php -->
@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 mb-1">Categories Management</h1>
                    <p class="text-muted mb-0">Organize wedding hall categories and tags</p>
                </div>
                <button class="btn btn-primary" onclick="showCreateCategoryModal()">
                    <i class="bi bi-plus-lg me-2"></i> Add Category
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Categories</div>
                        <div class="stat-value">{{ $totalCategories }}</div>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>+8.3%</span>
                        </div>
                    </div>
                    <div class="stat-icon primary">
                        <i class="bi bi-tags"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Active Categories</div>
                        <div class="stat-value">{{ $activeCategories }}</div>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>+12.5%</span>
                        </div>
                    </div>
                    <div class="stat-icon success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-label">Total Listings</div>
                        <div class="stat-value">{{ $totalListings }}</div>
                        <div class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>+15.7%</span>
                        </div>
                    </div>
                    <div class="stat-icon warning">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="row g-3">
        <!-- Category 1 -->
        @foreach ($categories as $category)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card category-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="category-icon bg-{{ $category->color ?? 'primary' }}">
                                <i class="bi bi-{{ $category->icon ?? 'tags' }}"></i>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" {{ $category->status ? 'checked' : '' }}
                                    onchange="toggleStatus({{ $category->id }}, this)">
                            </div>
                        </div>

                        <h5 class="card-title mb-2">{{ $category->name }}</h5>
                        <p class="card-text text-muted small mb-3">
                            {{ $category->description }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-medium">{{ $category->halls_count }} Listings</div>
                                <small class="text-muted">
                                    {{ $category->status ? 'Active' : 'Inactive' }}
                                </small>
                            </div>

                            <div class="d-flex gap-1">
                                <button class="btn-action" onclick="showEditCategoryModal({{ $category->toJson() }})">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button class="btn-action" onclick="showCategoryDetails({{ $category->toJson() }})">
                                    <i class="bi bi-eye"></i>
                                </button>

                                <form method="POST" action="{{ route('categories.destroy', $category) }}"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-action text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach



        <!-- Bulk Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">Bulk Category Actions</h5>
                                <p class="text-muted mb-0">Apply actions to selected categories</p>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary" onclick="activateSelected()">
                                    <i class="bi bi-power me-2"></i> Activate Selected
                                </button>
                                <button class="btn btn-outline-warning" onclick="deactivateSelected()">
                                    <i class="bi bi-slash-circle me-2"></i> Deactivate Selected
                                </button>
                                <button class="btn btn-outline-danger"
                                    onclick="showConfirm('Delete Categories', 'Delete all selected categories?', function() { showToast('Categories deleted', 'success') })">
                                    <i class="bi bi-trash me-2"></i> Delete Selected
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State Example -->
        <div class="row d-none" id="emptyCategories">
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                    <h3 class="empty-state-title">No Categories Found</h3>
                    <p class="empty-state-text">Start by creating your first category to organize wedding halls.</p>
                    <button class="btn btn-primary" onclick="showCreateCategoryModal()">
                        <i class="bi bi-plus-lg me-2"></i> Create First Category
                    </button>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            // دالة عرض التفاصيل (Show)
            function showCategoryDetails(category) {
                const modalHTML = `
    <div class="modal fade" id="showCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <div class="category-icon bg-${category.color || 'primary'} mx-auto mb-3 shadow-sm" style="width: 70px; height: 70px; font-size: 1.8rem;">
                        <i class="bi bi-${category.icon || 'tags'}"></i>
                    </div>
                    <h4 class="fw-bold mb-1">${category.name}</h4>
                    <p class="text-muted small mb-3">/${category.slug}</p>

                    <div class="bg-light rounded p-3 mb-4 text-start">
                        <label class="small text-muted fw-bold mb-1">Description</label>
                        <p class="mb-0 small">${category.description || 'No description available for this category.'}</p>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="small text-muted">Status</div>
                                <span class="badge ${category.status ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'} rounded-pill">
                                    ${category.status ? 'Active' : 'Inactive'}
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="small text-muted">Total Listings</div>
                                <div class="fw-bold text-dark">${category.halls_count || 0}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-primary w-100" onclick="showEditCategoryModal(${JSON.stringify(category).replace(/"/g, '&quot;')})">
                        Edit Details
                    </button>
                </div>
            </div>
        </div>
    </div>`;

                document.getElementById('showCategoryModal')?.remove();
                document.body.insertAdjacentHTML('beforeend', modalHTML);
                new bootstrap.Modal(document.getElementById('showCategoryModal')).show();
            }

            // دالة التعديل (Edit) المحدثة
            function showEditCategoryModal(category) {
                const modalHTML = `
    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/categories/${category.id}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3 text-center">
                             <div id="editPreviewIcon" class="category-icon bg-${category.color || 'primary'} mx-auto mb-2">
                                <i class="bi bi-${category.icon || 'tags'}"></i>
                            </div>
                            <small class="text-muted">Live Preview</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Category Name</label>
                            <input type="text" name="name" class="form-control" value="${category.name}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" class="form-control" rows="3">${category.description || ''}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Icon Color</label>
                            <div class="d-flex gap-2">
                                ${['primary', 'success', 'warning', 'danger', 'info'].map(c => `
                                                    <div class="color-option ${category.color === c ? 'selected' : ''}" onclick="updateEditPreviewColor('${c}', this)">
                                                        <div class="color-circle bg-${c}"></div>
                                                    </div>
                                                `).join('')}
                            </div>
                            <input type="hidden" name="color" id="editSelectedColor" value="${category.color || 'primary'}">
                        </div>
                        <div class="modal-footer px-0 pb-0 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>`;

                document.getElementById('editCategoryModal')?.remove();
                document.body.insertAdjacentHTML('beforeend', modalHTML);
                new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
            }

            // دوال المساعدة للتحديث المباشر لشكل الأيقونة في التعديل
            function updateEditPreviewColor(color, element) {
                const preview = document.getElementById('editPreviewIcon');
                preview.className = `category-icon bg-${color} mx-auto mb-2`;
                document.getElementById('editSelectedColor').value = color;
                document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
                element.classList.add('selected');
            }

            function showEditCategoryModal(category) {
                const modalHTML = `
    <div class="modal fade" id="editCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category: ${category.name}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/categories/${category.id}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" value="${category.name}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Slug</label>
                            <input type="text" name="slug" class="form-control" value="${category.slug}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">${category.description || ''}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon Color</label>
                            <div class="d-flex gap-2">
                                ${['primary', 'success', 'warning', 'danger', 'info'].map(c => `
                                                                    <div class="color-option ${category.color === c ? 'selected' : ''}" onclick="selectColor('${c}', this)">
                                                                        <div class="color-circle bg-${c}"></div>
                                                                    </div>
                                                                `).join('')}
                            </div>
                            <input type="hidden" name="color" id="selectedColor" value="${category.color || 'primary'}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <select name="icon" class="form-select">
                                <option value="gem" ${category.icon === 'gem' ? 'selected' : ''}>Gem</option>
                                <option value="flower2" ${category.icon === 'flower2' ? 'selected' : ''}>Flower</option>
                                <option value="building" ${category.icon === 'building' ? 'selected' : ''}>Building</option>
                                <option value="heart" ${category.icon === 'heart' ? 'selected' : ''}>Heart</option>
                            </select>
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>`;

                const oldModal = document.getElementById('editCategoryModal');
                if (oldModal) oldModal.remove();

                document.body.insertAdjacentHTML('beforeend', modalHTML);
                new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
            }

            function toggleStatus(id, checkbox) {
                // 1. ابحث عن حاوية الكارد الخاصة بهذا القسم لتحديث النصوص بداخلها
                const card = checkbox.closest('.category-card');
                const statusLabel = card.querySelector('.text-muted small'); // المكان الذي يظهر فيه كلمة Active/Inactive

                fetch(`/categories/${id}/toggle`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        // 2. تحديث حالة الـ checkbox بناءً على رد السيرفر
                        checkbox.checked = data.status;

                        // 3. تحديث النص المكتوب تحت عدد Listings بدون ريفرش
                        if (statusLabel) {
                            statusLabel.innerText = data.status ? 'Active' : 'Inactive';
                        }

                        // 4. (إختياري) إظهار رسالة توست سريعة
                        showToast(`Category is now ${data.status ? 'Active' : 'Inactive'}`, 'success');
                    })
                    .catch(err => {
                        // في حال فشل الطلب، نرجع الـ checkbox لحالته الأصلية وننبه المستخدم
                        checkbox.checked = !checkbox.checked;
                        showToast('Something went wrong', 'danger');
                    });
            }

            function showCreateCategoryModal() {
                const modalHTML = `
    <div class="modal fade" id="createCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('categories.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Luxury Halls" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Slug</label>
                            <input type="text" name="slug" class="form-control" placeholder="luxury-halls" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon Color</label>
                            <div class="d-flex gap-2">
                                <div class="color-option selected" onclick="selectColor('primary', this)"><div class="color-circle bg-primary"></div></div>
                                <div class="color-option" onclick="selectColor('success', this)"><div class="color-circle bg-success"></div></div>
                                <div class="color-option" onclick="selectColor('warning', this)"><div class="color-circle bg-warning"></div></div>
                                <div class="color-option" onclick="selectColor('danger', this)"><div class="color-circle bg-danger"></div></div>
                                <div class="color-option" onclick="selectColor('info', this)"><div class="color-circle bg-info"></div></div>
                            </div>
                            <input type="hidden" name="color" id="selectedColor" value="primary">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <select name="icon" class="form-select">
                                <option value="gem">Gem</option>
                                <option value="flower2">Flower</option>
                                <option value="building">Building</option>
                                <option value="heart">Heart</option>
                            </select>
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>`;

                // تنظيف المودال القديم لمنع التكرار
                const oldModal = document.getElementById('createCategoryModal');
                if (oldModal) oldModal.remove();

                document.body.insertAdjacentHTML('beforeend', modalHTML);
                new bootstrap.Modal(document.getElementById('createCategoryModal')).show();
            }

            // تعديل دالة اختيار اللون لتعمل بشكل صحيح مع الـ dynamic HTML
            function selectColor(color, element) {
                document.getElementById('selectedColor').value = color;
                document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
                element.classList.add('selected');
            }

            function editCategory(categoryId) {
                showToast('Edit category ' + categoryId, 'info');
            }
        </script>

        <style>
            /* عند اختيار الـ checkbox، قم بتغيير حدود الكارد */
            .category-card:has(.category-checkbox:checked) {
                border: 2px solid var(--bs-primary);
                background-color: rgba(var(--bs-primary-rgb), 0.05);
            }

            .category-card {
                border: none;
                box-shadow: var(--shadow);
                transition: var(--transition);
                height: 100%;
            }

            .category-card:hover {
                transform: translateY(-4px);
                box-shadow: var(--shadow-lg);
            }

            .category-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.25rem;
            }

            .color-option {
                cursor: pointer;
                padding: 2px;
                border-radius: 50%;
                border: 2px solid transparent;
                transition: var(--transition);
            }

            .color-option.selected {
                border-color: var(--gray-400);
            }

            .color-circle {
                width: 32px;
                height: 32px;
                border-radius: 50%;
            }
        </style>
    @endsection

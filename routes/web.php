<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\HallImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController; // أضف هذا
use App\Http\Middleware\VenueOwnerMiddleware;
use App\Http\Controllers\VenueOwnerController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Venue Owner Routes
Route::middleware(['auth', VenueOwnerMiddleware::class])->prefix('venue')->name('venue.')->group(function () {
    Route::get('/dashboard', [VenueOwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/halls', [VenueOwnerController::class, 'halls'])->name('halls.index');
    Route::get('/halls/create', [VenueOwnerController::class, 'createHall'])->name('halls.create');
    Route::post('/halls', [VenueOwnerController::class, 'storeHall'])->name('halls.store');
    Route::get('/halls/{hall}/edit', [VenueOwnerController::class, 'editHall'])->name('halls.edit');
    Route::patch('/halls/{hall}', [VenueOwnerController::class, 'updateHall'])->name('halls.update');
    Route::get('/halls/{hall}/preview', [VenueOwnerController::class, 'previewHall'])->name('halls.preview');
    Route::delete('/halls/{hall}', [VenueOwnerController::class, 'deleteHall'])->name('halls.delete');
    
    Route::get('/halls/{hall}/images', [VenueOwnerController::class, 'manageImages'])->name('halls.images');
    Route::post('/halls/{hall}/images', [VenueOwnerController::class, 'storeImage'])->name('halls.images.store');
    Route::patch('/halls/{hall}/images/{image}/primary', [VenueOwnerController::class, 'setPrimaryImage'])->name('halls.images.primary');
    Route::delete('/halls/{hall}/images/{image}', [VenueOwnerController::class, 'deleteImage'])->name('halls.images.delete');

    Route::get('/halls/{hall}/services', [VenueOwnerController::class, 'manageServices'])->name('halls.services');
    Route::post('/halls/{hall}/services', [VenueOwnerController::class, 'storeService'])->name('halls.services.store');
    Route::delete('/halls/{hall}/services/{service}', [VenueOwnerController::class, 'deleteService'])->name('halls.services.delete');

    Route::get('/service-categories', [VenueOwnerController::class, 'serviceCategories'])->name('service-categories.index');
    Route::post('/service-categories', [VenueOwnerController::class, 'storeServiceCategory'])->name('service-categories.store');
    Route::delete('/service-categories/{category}', [VenueOwnerController::class, 'deleteServiceCategory'])->name('service-categories.delete');
    
    Route::get('/bookings', [VenueOwnerController::class, 'bookings'])->name('bookings.index');
    Route::get('/bookings/{booking}', [VenueOwnerController::class, 'showBooking'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [VenueOwnerController::class, 'updateBookingStatus'])->name('bookings.update-status');
    
    Route::get('/analytics', [VenueOwnerController::class, 'analytics'])->name('analytics');
    Route::get('/profile', [VenueOwnerController::class, 'profile'])->name('profile');
    Route::patch('/profile', [VenueOwnerController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [VenueOwnerController::class, 'updateAvatar'])->name('profile.avatar.update');
});


// 1. الصفحة الرئيسية - FIXED
Route::get('/', [HomeController::class, 'index'])->name('home');

// 2. صفحات Auth - Handled by auth.php

// 3. Route الـ explore - ADD THIS
// في routes/web.php
Route::get('/explore', [HallController::class, 'explore'])->name('explore');
Route::get('/explore/filter', [HallController::class, 'filter'])->name('explore.filter');
Route::get('/halls/{hall}/quick-view', [HallController::class, 'quickView'])->name('halls.quickView');
// 4. Route تفاصيل القاعة - FIXED
Route::get('/venue/{hall}', [HallController::class, 'show'])->name('venue.details');
// أو إذا بدك تحافظ على الاسم القديم:
// Route::get('/hall/{id}', [HallController::class, 'show'])->name('hall-details');

// 5. صفحات تحتاج تسجيل دخول
Route::middleware(['auth'])->group(function () {
    // Dashboard
    // Dashboard
    Route::get('/dashboard', [BookingController::class, 'dashboard'])->name('dashboard');



    // Favorites
    Route::get('/favorites', function () {
        return view('pages.favorites');
    })->name('favorites');

    // Users
    Route::get('/users', function () {
        return view('pages.users');
    })->name('users');

    Route::get('/users/{id}', function ($id) {
        return "User ID: " . $id;
    });

    // Halls Management
    Route::get('/listings', [HallController::class, 'index'])->name('listings');
    Route::resource('halls', HallController::class);

    // Requests
    Route::get('/requests', function () {
        return view('pages.requests');
    })->name('requests');

    // Categories Management
    Route::resource('categories', CategoryController::class);
    Route::patch('/categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');
    Route::patch('/categories/bulk-toggle', [CategoryController::class, 'bulkToggle'])->name('categories.bulk-toggle');
    Route::delete('/categories/bulk-delete', [CategoryController::class, 'bulkDelete'])->name('categories.bulk-delete');

    // Reports
    Route::get('/reports', function () {
        return view('pages.reports');
    })->name('reports');

    // Settings
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Hall Images Management
    Route::get('/halls/{hall}/images', [HallImageController::class, 'index'])->name('hall-images.index');
    Route::patch('/hall-images/{image}/primary', [HallImageController::class, 'setPrimary'])->name('hall-images.primary');
    Route::delete('/hall-images/{image}', [HallImageController::class, 'destroy'])->name('hall-images.destroy');

    // Users Management
    Route::resource('users', UserController::class);
});

// Logout
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('pages.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/search', [HallController::class, 'adminSearch'])->name('admin.search');
});
// Bookings routes
Route::middleware(['auth'])->group(function () {
    // الحجز من قبل المستخدم
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // إدارة الحجوزات (للمشرفين)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.update-status');
        Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
    });
});
Route::get('/halls/{hall}/booking', [BookingController::class, 'create'])->name('bookings.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
// ===== Booking Routes =====
Route::middleware(['auth'])->group(function () {
    // صفحة حجز القاعة
    Route::get('/halls/{hall}/booking', [BookingController::class, 'create'])->name('bookings.create');

    // حفظ الحجز
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // تأكيد الحجز
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');

    // حجوزات المستخدم
    Route::get('/my-bookings', [BookingController::class, 'userBookings'])->name('user.bookings');

    // عرض حجز معين
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');

    // إلغاء الحجز
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // الدفع
    Route::get('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::post('/bookings/{booking}/process-payment', [BookingController::class, 'processPayment'])->name('bookings.process-payment');
});
require __DIR__.'/auth.php';

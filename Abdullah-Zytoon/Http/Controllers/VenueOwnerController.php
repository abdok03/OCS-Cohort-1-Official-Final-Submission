<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Booking;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class VenueOwnerController extends Controller
{
    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $hallIds = $user->halls->pluck('id');

       $stats = [
    'total_halls' => $user->halls->count(),

    'active_bookings' => Booking::whereIn('hall_id', $hallIds)
        ->whereIn('status', ['confirmed', 'approved_by_admin', 'approved'])
        ->count(),

    'pending_requests' => Booking::whereIn('hall_id', $hallIds)
        ->where('status', 'pending')
        ->count(),

    'total_revenue' => Booking::whereIn('hall_id', $hallIds)
        ->where('status', 'confirmed')
        ->sum('total_price'),
];


        $recentBookings = Booking::whereIn('hall_id', $hallIds)
            ->with(['user', 'hall'])
            ->latest()
            ->take(5)
            ->get();

        return view('venue.dashboard', compact('stats', 'recentBookings'));
    }

    public function halls()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $halls = $user->halls()->with(['primaryImage', 'categories'])->latest()->paginate(10);
        return view('venue.halls.index', compact('halls'));
    }

    public function previewHall(Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }
        $hall->load(['images', 'categories', 'user']);
        return view('venue.halls.preview', compact('hall'));
    }

    public function createHall()
    {
        $categories = Category::all();
        return view('venue.halls.create', compact('categories'));
    }

    public function storeHall(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity_min' => 'required|integer|min:1',
            'capacity_max' => 'required|integer|gte:capacity_min',
            'price_per_hour' => 'required|numeric|min:0',
            'city' => 'required|string',
            'address' => 'required|string',
            'images.*' => 'nullable|image|max:5120',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20480', // Max 20MB
        ]);

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('halls/videos', 'public');
        }

        $hall = Hall::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'capacity_min' => $request->capacity_min,
            'capacity_max' => $request->capacity_max,
            'price_per_hour' => $request->price_per_hour,
            'price_per_day' => $request->price_per_hour * 12,
            'city' => $request->city,
            'address' => $request->address,
            'status' => 1,
            'video_path' => $videoPath,
        ]);

        if ($request->has('categories')) {
            $hall->categories()->sync($request->categories);
        }

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('halls/' . $hall->id, 'public');
                \App\Models\HallImage::create([
                    'hall_id' => $hall->id,
                    'image_path' => $path,
                    'is_primary' => ($index === 0), // First image is primary
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('venue.halls.index')->with('success', 'Hall added successfully with images!');
    }

    public function bookings(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $hallIds = $user->halls->pluck('id');
        
        $query = Booking::whereIn('hall_id', $hallIds)
            ->with(['user', 'hall']);

        // Filter by Search (Booking ID or User Name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Date Range
        if ($request->filled('from_date')) {
            $query->whereDate('event_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('event_date', '<=', $request->to_date);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(15);

        return view('venue.bookings.index', compact('bookings'));
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        // Verify ownership
        if ($booking->hall->user_id !== Auth::id()) {
            abort(403);
        }

       $request->validate([
            'status' => 'required|in:approved,rejected,approved_by_admin,rejected_by_admin',
            'notes' => 'nullable|string|max:500',
        ]);

        $status = $request->status;
        
        // Normalize status if coming from simple 'approved'/'rejected' inputs
        if ($status === 'approved') $status = 'approved_by_admin';
        if ($status === 'rejected') $status = 'rejected_by_admin';

        $updateData = ['status' => $status];

        if ($status === 'approved_by_admin') {
            $updateData['approved_at'] = now();
            $updateData['approved_by'] = Auth::id();
            $updateData['admin_notes'] = $request->notes;
        } else {
            $updateData['rejected_at'] = now();
            $updateData['rejected_by'] = Auth::id();
            $updateData['rejection_reason'] = $request->notes;
        }

        $booking->update($updateData);

        return back()->with('success', 'Booking status updated.');
    }

    public function editHall(Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::all();
        $selectedCategories = $hall->categories->pluck('id')->toArray();
        return view('venue.halls.edit', compact('hall', 'categories', 'selectedCategories'));
    }

    public function updateHall(Request $request, Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity_min' => 'required|integer|min:1',
            'capacity_max' => 'required|integer|gte:capacity_min',
            'price_per_hour' => 'required|numeric|min:0',
            'city' => 'required|string',
            'address' => 'required|string',
            'images.*' => 'nullable|image|max:5120',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20480',
        ]);

        $updateData = [
            'name' => $request->name,
            'description' => $request->description,
            'capacity_min' => $request->capacity_min,
            'capacity_max' => $request->capacity_max,
            'price_per_hour' => $request->price_per_hour,
            'price_per_day' => $request->price_per_hour * 12,
            'city' => $request->city,
            'address' => $request->address,
        ];

        if ($request->hasFile('video')) {
            if ($hall->video_path) {
                Storage::disk('public')->delete($hall->video_path);
            }
            $updateData['video_path'] = $request->file('video')->store('halls/videos', 'public');
        }

        $hall->update($updateData);

        if ($request->has('categories')) {
            $hall->categories()->sync($request->categories);
        }

        // Handle additional Image Uploads
        if ($request->hasFile('images')) {
            $currentMaxSort = $hall->images()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('halls/' . $hall->id, 'public');
                \App\Models\HallImage::create([
                    'hall_id' => $hall->id,
                    'image_path' => $path,
                    'is_primary' => ($hall->images()->count() === 0), // If no images exist, first becomes primary
                    'sort_order' => $currentMaxSort + $index + 1,
                ]);
            }
        }

        return redirect()->route('venue.halls.index')->with('success', 'Hall updated successfully!');
    }

    public function manageImages(Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }
        $hall->load('images');
        return view('venue.halls.images', compact('hall'));
    }

    public function storeImage(Request $request, Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'image' => 'required|image|max:5120', // Max 5MB
        ]);

        $path = $request->file('image')->store('halls/' . $hall->id, 'public');

        \App\Models\HallImage::create([
            'hall_id'    => $hall->id,
            'image_path' => $path,
            'is_primary' => $hall->images()->count() === 0, // First image is primary
            'sort_order' => $hall->images()->max('sort_order') + 1,
        ]);

        return back()->with('success', 'Image uploaded successfully!');
    }

    public function setPrimaryImage(Hall $hall, \App\Models\HallImage $image)
    {
        if ($hall->user_id !== Auth::id() || $image->hall_id !== $hall->id) {
            abort(403);
        }

        $hall->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Primary image updated.');
    }

    public function deleteImage(Hall $hall, \App\Models\HallImage $image)
    {
        if ($hall->user_id !== Auth::id() || $image->hall_id !== $hall->id) {
            abort(403);
        }

        if ($image->is_primary && $hall->images()->count() > 1) {
            return back()->with('error', 'Cannot delete primary image. Set another primary first.');
        }

        \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    public function showBooking(Booking $booking)
    {
        if ($booking->hall->user_id !== Auth::id()) {
            abort(403);
        }
        $booking->load(['user', 'hall']);
        return view('venue.bookings.show', compact('booking'));
    }

    public function profile()
    {
        return view('venue.profile');
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['first_name', 'last_name', 'email', 'phone']));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();

            // Store in avatars directory
            $file->storeAs('public/avatars', $filename);

            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $user->avatar = $filename;
            $user->save();
            
            return back()->with('success', 'Avatar updated successfully.');
        }

        return back()->with('error', 'No file uploaded.');
    }

    public function analytics(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $hallIds = $user->halls->pluck('id');
        
        $period = $request->get('period', '6months');
        $startDate = now();

        switch ($period) {
            case 'month':
                $startDate = now()->startOfMonth();
                break;
            case '3months':
                $startDate = now()->subMonths(3)->startOfMonth();
                break;
            case 'year':
                $startDate = now()->subYear()->startOfMonth();
                break;
            default: // 6 months
                $startDate = now()->subMonths(6)->startOfMonth();
                break;
        }

        $bookingsOverTime = Booking::whereIn('hall_id', $hallIds)
            ->whereIn('status', ['approved', 'confirmed'])
            ->where('event_date', '>=', $startDate)
            ->selectRaw('DATE_FORMAT(event_date, "%b %Y") as month, SUM(total_price) as revenue, COUNT(*) as count, event_date')
            ->groupBy('month', 'event_date')
            ->orderBy('event_date')
            ->get();

        // Calculate Metrics
        $totalBookingsCount = Booking::whereIn('hall_id', $hallIds)->where('event_date', '>=', $startDate)->count();
        $approvedBookingsCount = Booking::whereIn('hall_id', $hallIds)->where('event_date', '>=', $startDate)->whereIn('status', ['approved', 'confirmed'])->count();
        $successRate = $totalBookingsCount > 0 ? ($approvedBookingsCount / $totalBookingsCount) * 100 : 0;
        
        $popularHospitality = Booking::whereIn('hall_id', $hallIds)
            ->where('event_date', '>=', $startDate)
            ->whereNotNull('hospitality_package')
            ->select('hospitality_package')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('hospitality_package')
            ->orderByDesc('count')
            ->first();

        return view('venue.analytics', compact('bookingsOverTime', 'successRate', 'popularHospitality', 'period'));
    }

    public function deleteHall(Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }
        foreach($hall->images as $image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);
        }
        $hall->delete();
        return redirect()->route('venue.halls.index')->with('success', 'Hall deleted successfully.');
    }

    public function manageServices(Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }
        $services = $hall->services()->latest()->get();
        $categories = \App\Models\ServiceCategory::where('user_id', Auth::id())->get();
        return view('venue.halls.services', compact('hall', 'services', 'categories'));
    }

    public function storeService(Request $request, Hall $hall)
    {
        if ($hall->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20480',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services/images', 'public');
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('services/videos', 'public');
        }

        \App\Models\HallService::create([
            'hall_id' => $hall->id,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image_path' => $imagePath,
            'video_path' => $videoPath,
        ]);

        return back()->with('success', 'Service added successfully!');
    }

    public function deleteService(Hall $hall, \App\Models\HallService $service)
    {
        if ($hall->user_id !== Auth::id() || $service->hall_id !== $hall->id) {
            abort(403);
        }

        if ($service->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($service->image_path);
        }
        if ($service->video_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($service->video_path);
        }

        $service->delete();

        return back()->with('success', 'Service deleted successfully.');
    }

    public function serviceCategories()
    {
        $categories = \App\Models\ServiceCategory::where('user_id', Auth::id())->latest()->get();
        return view('venue.services.categories', compact('categories'));
    }

    public function storeServiceCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        \App\Models\ServiceCategory::create([
            'user_id' => Auth::id(),
            'name' => $request->name
        ]);
        return back()->with('success', 'Category added.');
    }

    public function deleteServiceCategory(\App\Models\ServiceCategory $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}

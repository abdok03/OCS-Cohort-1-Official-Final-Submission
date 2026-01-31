<?php

namespace App\Http\Controllers;
use App\Models\Hall;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class HallController extends Controller
{

   public function index(Request $request)
{
    $query = Hall::with(['categories', 'primaryImage']);

    if ($request->filled('category')) {
        $query->whereHas('categories', function($q) use ($request) {
            $q->where('categories.id', $request->category);
        });
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $halls = $query->latest()->paginate(4);
    $categories = Category::all();
    $owners = \App\Models\User::where('role', 'owner')->get();

    $totalHalls = Hall::count();
    $activeHalls = Hall::where('status', 1)->count();
    $pendingHalls = Hall::where('status', 0)->count();
    $totalValue = Hall::sum('price_per_hour');
    return view('pages.listings', compact('halls', 'categories', 'owners', 'totalHalls', 'activeHalls', 'pendingHalls','totalValue'));
}


    public function create()
    {
        $categories = Category::all();
        $owners = \App\Models\User::where('role', 'owner')->get();
        return view('halls.create', compact('categories', 'owners'));
    }


  public function store(Request $request)
{
    // dd(request()->all());

    $request->validate([
        'name' => 'required|string|max:255',
        // 'slug' => 'required|string|max:255|unique:halls,slug',
        'description' => 'nullable|string',
        'capacity_min' => 'required|integer|min:1',
        'capacity_max' => 'required|integer|min:1',
        'price_per_day' => 'required|numeric|min:0',
        'price_per_hour' => 'required|numeric|min:0',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'status' => 'nullable|boolean',
        'categories' => 'required|array',
        'owner_id' => 'nullable|exists:users,id',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:5120'
    ]);

    $data = $request->only(
        'name', 'slug', 'description', 'capacity_min', 'capacity_max',
        'price_per_day', 'price_per_hour', 'address', 'city'
    );

    $data['slug'] = Str::slug($request->name) . '-' . uniqid();
    $data['status'] = $request->status == '1' ? 1 : 0;
    
    if (Auth::user()->role === 'admin' && $request->filled('owner_id')) {
        $data['user_id'] = $request->owner_id;
    } else {
        $data['user_id'] = Auth::id();
    }
// dd($data);
    $hall = Hall::create($data);

    $hall->categories()->sync($request->categories);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('halls', 'public');

            $hall->images()->create([
                'image_path' => $path,
                'is_primary' => $index === 0,
                'sort_order' => $index,
            ]);
        }
    }

    return redirect()->route('halls.index')->with('success', 'Hall created successfully');
}
public function explore(Request $request)
{
    $query = Hall::with(['images', 'categories'])
                ->where('status', 1);

    if ($request->has('category')) {
        $query->whereHas('categories', function($q) use ($request) {
            $q->where('categories.id', $request->category);
        });
    }

    if ($request->has('location')) {
        $query->where(function($q) use ($request) {
            $q->where('city', 'LIKE', '%' . $request->location . '%')
              ->orWhere('address', 'LIKE', '%' . $request->location . '%');
        });
    }

    $halls = $query->latest()->paginate(12);
    $categories = Category::where('status', 1)->get();

    return view('pages.explore', compact('halls', 'categories'));
}

public function filter(Request $request)
{
    $query = Hall::with(['images', 'categories'])
                ->where('status', 1);

    if ($request->has('cities') && !empty($request->cities)) {
        $cities = explode(',', $request->cities);
        $query->whereIn('city', $cities);
    }

    if ($request->has('max_price')) {
        $query->where('price_per_day', '<=', $request->max_price);
    }

    if ($request->has('categories') && !empty($request->categories)) {
        $categories = explode(',', $request->categories);
        $query->whereHas('categories', function($q) use ($categories) {
            $q->whereIn('categories.id', $categories);
        });
    }

    if ($request->has('capacities') && !empty($request->capacities)) {
        $ranges = explode(',', $request->capacities);
        $query->where(function($q) use ($ranges) {
            foreach($ranges as $range) {
                $parts = explode('-', $range);
                $min = $parts[0];
                $max = $parts[1] ?? 10000;
                $q->orWhereBetween('capacity_max', [$min, $max]);
            }
        });
    }

    // Sorting
    switch ($request->get('sort', 'recommended')) {
        case 'price_low':
            $query->orderBy('price_per_day', 'asc');
            break;
        case 'price_high':
            $query->orderBy('price_per_day', 'desc');
            break;
        case 'capacity':
            $query->orderBy('capacity_max', 'desc');
            break;
        case 'newest':
            $query->orderBy('created_at', 'desc');
            break;
        default:
            $query->orderBy('featured', 'desc')->latest();
    }

    $halls = $query->get()->map(function($hall) {
        return [
            'id' => $hall->id,
            'name' => $hall->name,
            'image' => $hall->images->first()
                ? asset('storage/' . $hall->images->first()->image_path)
                : 'https://images.unsplash.com/photo-1519167758481-83f550bb49b3',
            'video' => $hall->video_path ? asset('storage/' . $hall->video_path) : null,
            'location' => $hall->city . ', ' . $hall->address,
            'capacity' => $hall->capacity_max,
            'price' => $hall->price_per_day,
            'rating' => '4.9 (124)',
            'category' => $hall->categories->first()->name ?? null,
            'featured' => $hall->featured ?? false
        ];
    });

    return response()->json([
        'halls' => $halls,
        'total' => $halls->count()
    ]);
}

public function quickView(Hall $hall)
{
    $hall->load(['images', 'categories']);
    return view('partials.quick-view-modal', compact('hall'));
}
public function show(Hall $hall)
{
    $hall->load(['images', 'categories', 'user']);
     $similarVenues = Hall::whereHas('categories', function($query) use ($hall) {
            $query->whereIn('categories.id', $hall->categories->pluck('id'));
        })
        ->where('id', '!=', $hall->id)
        ->where('status', 1)
        ->with(['images', 'categories'])
        ->limit(3)
        ->get()
        ->map(function($similarHall) {
        return [
            'id' => $similarHall->id,
            'name' => $similarHall->name,
            'price_per_day' => $similarHall->price_per_day,
            'image' => $similarHall->images->first() ?
                asset('storage/' . $similarHall->images->first()->image_path) :
                'https://images.unsplash.com/photo-1519167758481-83f550bb49b3',
            'category' => $similarHall->categories->first()->name ?? 'Wedding Hall',
            'rating' => 4.5,
            'reviews' => rand(50, 200),
        ];
    });
           $averageRating = 4.5; // قيمة افتراضية
    $reviewsCount = 124; // قيمة افتراضية
     $data = [
        'hall' => $hall,
        'similarVenues' => $similarVenues,
        'averageRating' => $averageRating,
        'reviewsCount' => $reviewsCount,
    ];
        $reviewsData = [
        'average_rating' => 4.5, // متوسط افتراضي
        'total_reviews' => 124,  // عدد افتراضي
        'reviews_list' => [
            [
                'user' => 'Sarah Mohammed',
                'avatar' => 'https://randomuser.me/api/portraits/women/32.jpg',
                'rating' => 5,
                'date' => '2024-03-15',
                'comment' => 'Absolutely stunning venue! The staff was incredibly professional.',
            ],
            [
                'user' => 'Ahmed Al-Saadi',
                'avatar' => 'https://randomuser.me/api/portraits/men/54.jpg',
                'rating' => 4,
                'date' => '2024-02-28',
                'comment' => 'Beautiful hall with excellent service.',
            ],
            [
                'user' => 'Layla Hassan',
                'avatar' => 'https://randomuser.me/api/portraits/women/67.jpg',
                'rating' => 5,
                'date' => '2024-01-10',
                'comment' => 'Best wedding venue in Jordan!',
            ],
        ]
    ];
    $featuredHalls = Hall::whereHas('categories', function($query) use ($hall) {
            $query->whereIn('categories.id', $hall->categories->pluck('id'));
        })
        ->where('id', '!=', $hall->id)
        ->where('status', 1)
        ->with(['images', 'categories'])
        ->limit(3)
        ->get()
        ->map(function($similarHall) {
            return [
                'id' => $similarHall->id,
                'name' => $similarHall->name,
                'price_per_day' => $similarHall->price_per_day,
                'image' => $similarHall->images->first() ?
                    asset('storage/' . $similarHall->images->first()->image_path) :
                    'https://images.unsplash.com/photo-1519167758481-83f550bb49b3',
                'category' => $similarHall->categories->first()->name ?? 'Wedding Hall',
                'location' => $similarHall->city . ', ' . $similarHall->address,
                'rating' => 4.5,
                'reviews' => rand(50, 200),
                'capacity' => $similarHall->capacity_max . ' Guests',
            ];
        });

    $venue = [
        'id' => $hall->id,
        'name' => $hall->name,
        'price' => $hall->price_per_day,
        'main_image' => $hall->images->first() ?
            asset('storage/' . $hall->images->first()->image_path) :
            'https://images.unsplash.com/photo-1519167758481-83f550bb49b3',
        'images' => $hall->images->map(function($image) {
            return asset('storage/' . $image->image_path);
        })->toArray(),
        'category' => $hall->categories->first()->name ?? 'Wedding Hall',
        'location' => $hall->city . ', ' . $hall->address,
        'rating' => 4.5,
        'reviews' => 124,
        'capacity' => $hall->capacity_max . ' Guests',
        'description' => $hall->description,
        'video_path' => $hall->video_path,
        'highlights' => [
            'Luxury interior design with crystal chandeliers',
            'Spacious ballroom with capacity up to ' . $hall->capacity_max . ' guests',
            'Professional sound and lighting systems',
            'Dedicated wedding planning team',
        ],
        'amenities' => [
            ['icon' => 'wifi', 'text' => 'High-speed WiFi'],
            ['icon' => 'parking', 'text' => 'Free Parking'],
            ['icon' => 'snowflake', 'text' => 'Air Conditioning'],
            ['icon' => 'wheelchair', 'text' => 'Wheelchair Accessible'],
        ],
        'pricing' => [
            'peak_season' => $hall->price_per_day * 1.25,
            'off_season' => $hall->price_per_day * 0.85,
            'weekend_surcharge' => 200,
            'minimum_hours' => 5,
        ],
         'reviews_list' => [  // أضف هذا
        [
            'user' => 'Sarah Mohammed',
            'avatar' => 'https://randomuser.me/api/portraits/women/32.jpg',
            'rating' => 5,
            'date' => '2024-03-15',
            'comment' => 'Absolutely stunning venue!',
        ],
        [
            'user' => 'Ahmed Al-Saadi',
            'avatar' => 'https://randomuser.me/api/portraits/men/54.jpg',
            'rating' => 4,
            'date' => '2024-02-28',
            'comment' => 'Beautiful hall with excellent service.',
        ],
        [
            'user' => 'Layla Hassan',
            'avatar' => 'https://randomuser.me/api/portraits/women/67.jpg',
            'rating' => 5,
            'date' => '2024-01-10',
            'comment' => 'Best wedding venue in Jordan!',
        ],
    ],
    ];

    // 3. تمرير جميع البيانات للـ view
    return view('pages.show', compact('venue', 'featuredHalls',));
}


    public function edit(Hall $hall)
    {
         $categories = Category::all();
         $owners = \App\Models\User::where('role', 'owner')->get();
        $hall->load('categories');
        return view('pages.edit', compact('hall', 'categories', 'owners'));
    }
public function update(Request $request, Hall $hall)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'capacity_min' => 'required|integer|min:1',
        'capacity_max' => 'required|integer|min:1',
        'price_per_day' => 'required|numeric|min:0',
        'price_per_hour' => 'required|numeric|min:0',
        'address' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'status' => 'nullable',
        'categories' => 'required|array',
        'images.*' => 'image|mimes:jpg,jpeg,png|max:5120' // وسم التحقق من الصور
    ]);

    $data = $request->only('name', 'description', 'capacity_min', 'capacity_max', 'price_per_day', 'price_per_hour', 'address', 'city');
    $data['slug'] = Str::slug($request->name) . '-' . uniqid();
    $data['status'] = $request->has('status') ? (int)$request->status : 0;

    if (Auth::user()->role === 'admin' && $request->filled('owner_id')) {
        $data['user_id'] = $request->owner_id;
    }

    $hall->update($data);
    $hall->categories()->sync($request->categories);

    if ($request->hasFile('images')) {
        $hall->images()->delete();

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('halls', 'public');

            $hall->images()->create([
                'image_path' => $path,
                'is_primary' => !$hall->images()->where('is_primary', true)->exists() && $index === 0,
                'sort_order' => $hall->images()->count() + $index,
            ]);
        }
    }

    return redirect()->route('halls.index')->with('success', 'Hall updated successfully');
}
    public function destroy(Hall $hall)
    {
        $hall->categories()->detach();
        $hall->delete();
        return redirect()->route('halls.index')->with('success', 'Hall deleted successfully');
    }

    public function adminSearch(Request $request)
    {
        $query = $request->input('query');
        if (!$query) {
            return redirect()->back();
        }

        // Search Halls
        $halls = Hall::where('name', 'LIKE', "%{$query}%")
            ->orWhere('city', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->with(['primaryImage', 'user'])
            ->get();

        // Search Users
        $users = \App\Models\User::where('first_name', 'LIKE', "%{$query}%")
            ->orWhere('last_name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->get();

        // Search Bookings (by User Name or Hall Name)
        $bookings = \App\Models\Booking::whereHas('user', function($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                  ->orWhere('last_name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('hall', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->with(['user', 'hall'])
            ->get();

        return view('admin.search-results', compact('halls', 'users', 'bookings', 'query'));
    }
}

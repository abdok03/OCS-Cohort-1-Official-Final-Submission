<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
public function index()
{
     $categories = Category::where('status', 1)
        ->withCount(['halls' => function($query) {
            $query->where('status', 1);
        }])
        ->get();
    $featuredHalls = Hall::with(['images', 'categories'])
        ->where('status', 1)
        ->latest()
        ->take(8)
        ->get()
        ->map(function($hall) {
            return [
                'id' => $hall->id,
                'name' => $hall->name,
                'price_per_hour' => $hall->price_per_hour,
                'price_per_day' => $hall->price_per_day,
                'image' => $hall->images->first() ?
                    asset('storage/' . $hall->images->first()->image_path) :
                    'https://images.unsplash.com/photo-1519167758481-83f550bb49b3?auto=format&fit=crop&w=800&q=80',
                'category' => $hall->categories->first()->name ?? 'Wedding Hall',
                'location' => $hall->city . ', ' . $hall->address,
                'rating' => 4.5,
                'reviews' => rand(50, 200),
                'capacity' => $hall->capacity_max . ' Guests',
                'description' => $hall->description,
            ];
        });

    // أضف هذا: جلب الـ categories
    $categories = Category::where('status', 1)->get();

    $stats = [
        'total_venues' => Hall::where('status', 1)->count(),
        'successful_events' => 2500,
        'client_satisfaction' => 98,
        'support_available' => '24/7',
    ];

    return view('pages.home', compact('featuredHalls', 'stats', 'categories'));
}
}

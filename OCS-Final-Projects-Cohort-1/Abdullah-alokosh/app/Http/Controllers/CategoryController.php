<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hall;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
       $categories = Category::withCount('halls')->get();
    $totalCategories = Category::count();
    $activeCategories = Category::where('status', 1)->count();
    $totalListings = Hall::count();

    return view('pages.categories', compact(
        'categories',
        'totalCategories',
        'activeCategories',
        'totalListings'
    ));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'color' => 'required|string',
            'icon' => 'required|string',
            'status' => 'nullable|boolean',
        ]);
        Category::create([
            'name'=> $request->name,
            'slug'=> $request->slug,
            'description'=> $request->description,
            'color' => $request->color,
            'icon' => $request->icon,
            'status'=> $request->status ?? 0,
        ]);
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }


    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));

    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'required',
            'icon' => 'required',
            'status' => 'nullable|boolean',
        ]);
        $data = $request->only('name','slug','description','color','icon');
        $data['status'] = $request->has('status') ? 1 : 0;
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }
    public function toggle(Category $category)
{
    $category->status = !$category->status;
    $category->save();
    return response()->json(['status' => $category->status]);
}
public function bulkToggle(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'status' => 'required|boolean'
    ]);

    Category::whereIn('id', $request->ids)->update(['status' => $request->status]);

    return response()->json(['message' => 'Updated successfully']);
}

public function bulkDelete(Request $request)
{
    $ids = $request->ids;
    Category::whereIn('id', $ids)->delete();

    return response()->json(['success' => true]);
}



//dd($request->all());
    public function destroy(Category $category)
    {
        $category->halls()->detach();
        $category->delete();
         return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Hall;
use App\Models\HallImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HallImageController extends Controller
{

    public function index(Hall $hall)
    {
         $images = $hall->images()->orderBy('sort_order')->get();
        return view('pages.hall-images.index', compact('hall', 'images'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request, Hall $hall)
    {
        dd($request->all(), $request->file('image'));

          $request->validate([
            'image' => 'required|image|max:2048',
            'is_primary' => 'nullable|boolean',
        ]);

        // إذا الصورة أساسية → ألغي القديمة
        if ($request->is_primary) {
            HallImage::where('hall_id', $hall->id)
                ->update(['is_primary' => false]);
        }

        $path = $request->file('image')->store('halls', 'public');

        HallImage::create([
            'hall_id'    => $hall->id,
            'image_path' => 'storage/' . $path,
            'is_primary' => $request->is_primary ?? false,
            'sort_order' => HallImage::where('hall_id', $hall->id)->max('sort_order') + 1,
        ]);

        return back()->with('success', 'تمت إضافة الصورة بنجاح');
    }
 public function setPrimary(HallImage $image)
    {
        HallImage::where('hall_id', $image->hall_id)
            ->update(['is_primary' => false]);

        $image->update(['is_primary' => true]);

        return back()->with('success', 'تم تعيين الصورة الأساسية');
    }

    public function show(HallImage $hallImage)
    {

    }


    public function edit(HallImage $hallImage)
    {

    }


    public function update(Request $request, HallImage $hallImage)
    {

    }


    public function destroy(HallImage $image)
    {

        if ($image->is_primary) {
            return back()->with('error', 'لا يمكن حذف الصورة الأساسية');
        }

        Storage::disk('public')->delete(str_replace('storage/', '', $image->image_path));

        $image->delete();

        return back()->with('success', 'تم حذف الصورة');
    }
}

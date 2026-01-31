<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
     public function index()
    {
        return view('pages.profile'); // نفس مسار ملف blade عندك
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $user = $request->user();
    $data = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'zip' => 'nullable|string|max:20',
        'bio' => 'nullable|string',
        'dob' => 'nullable|date',
        'wedding_date' => 'nullable|date',
    ]);

    $user->update($data);

return redirect()->route('profile')->with('status', 'Profile updated!');

}


    /**
     * Delete the user's account.
     */
    public function rules(): array
{
    return [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
        'phone' => ['nullable', 'string', 'max:20'],
        'address' => ['nullable', 'string', 'max:255'],
        'city' => ['nullable', 'string', 'max:100'],
        'state' => ['nullable', 'string', 'max:100'],
        'zip' => ['nullable', 'string', 'max:20'],
        'bio' => ['nullable', 'string'],
    ];
}


public function updateAvatar(Request $request)
{


    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    /** @var User $user */
    $user = Auth::user();

    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/avatars', $filename);

        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }
        $user->avatar = $filename;
        $user->save();
    }

    return response()->json([
        'success' => true,
        'avatar_url' => asset('storage/avatars/' . $user->avatar)
    ]);
}


    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

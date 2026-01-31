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
        $role = Auth::user()->role;
        
        return match($role) {
            'admin' => view('pages.profile'),
            'owner' => view('venue.profile'),
            default => view('pages.user-profile'),
        };
    }

    public function settings()
    {
        $role = Auth::user()->role;

        return match($role) {
            'admin' => view('pages.settings'),
            'owner' => view('venue.profile'), // Venue settings are currently in the profile page
            default => view('pages.user-profile'),
        };
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
    try {
        \Log::info('updateAvatar attempt', ['files' => $request->allFiles()]);
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();

            // Store in the 'avatars' subdirectory of the 'public' disk
            $path = $file->storeAs('avatars', $filename, 'public');
            \Log::info('File stored successfully', ['path' => $path]);

            // Deletion check
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $user->avatar = $path; // This will be 'avatars/filename.jpg'
            $user->save();
            \Log::info('User record updated', ['user_id' => $user->id, 'avatar' => $path]);

            return response()->json([
                'success' => true,
                'avatar_url' => asset('storage/' . $user->avatar)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded'], 400);
    } catch (\Exception $e) {
        \Log::error('Avatar upload error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
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

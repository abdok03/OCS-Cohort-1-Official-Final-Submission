<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class VenueAvatarUpload extends Component
{
    use WithFileUploads;

    public $avatar;
    public $avatarUrl;
    public $uploading = false;

    public function mount()
    {
        $this->avatarUrl = $this->getAvatarUrl();
    }

    public function getAvatarUrl()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            return asset('storage/' . $user->avatar);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=D4AF37&color=fff&size=200';
    }

    public function updatedAvatar()
    {
        $this->uploading = true;

        $this->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        try {
            /** @var User $user */
            $user = Auth::user();

            // Store the new avatar (returns path like 'avatars/xyz.png')
            $path = $this->avatar->store('avatars', 'public');

            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Update user
            $user->avatar = $path;
            $user->save();

            // Update local URL for preview
            $this->avatarUrl = asset('storage/' . $path);

            session()->flash('success', 'Profile picture updated successfully!');
            
            // Emit event to update navbars
            $this->dispatch('avatarUpdated');

        } catch (\Exception $e) {
            session()->flash('error', 'Update failed: ' . $e->getMessage());
        }

        $this->uploading = false;
        $this->avatar = null;
    }

    public function render()
    {
        return view('livewire.venue-avatar-upload');
    }
}

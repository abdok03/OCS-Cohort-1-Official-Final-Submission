<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AvatarUpload extends Component
{
    use WithFileUploads;
protected $listeners = ['avatarUpdated' => 'refreshAvatar'];

    public $avatar;
    public $avatarUrl;
    public $uploading = false;

    public function mount()
    {
        $this->avatarUrl = $this->getAvatarUrl();
    }
public function refreshAvatar()
{
    $this->avatarUrl = $this->getAvatarUrl();
}

    public function getAvatarUrl()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            return asset('storage/' . $user->avatar);
        }

        return asset('images/default-avatar.png'); // تأكد من وجود صورة افتراضية
    }
// الطريقة البديلة
public function updatedAvatar()
{
    $this->uploading = true;

    $this->validate([
        'avatar' => 'required|image|max:1024',
    ]);

    try {
        // رفع الصورة
        $filename = $this->avatar->store('avatars', 'public');

        // تحديث المستخدم
           /** @var User $user */
        $user = Auth::user();
        $user->avatar = $filename;
        $user->save();

        // تحديث رابط الصورة بعد رفعها
        $this->avatarUrl = asset('storage/' . $filename);

        // رسالة نجاح
        session()->flash('success', 'تم تحديث الصورة الشخصية بنجاح!');

    } catch (\Exception $e) {
        session()->flash('error', 'فشل رفع الصورة: ' . $e->getMessage());
    }

    $this->uploading = false;
    $this->avatar = null;
}
    public function render()
    {
        return view('livewire.avatar-upload');
    }
}

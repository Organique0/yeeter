<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $avatar;
    public $file;
    public mixed $fileSystemDisk;

    //cropper config
    public $config = ['guides' => false, 'aspectRatio' => 1,  'viewMode' => 1, 'minCropBoxWidth' => 100, 'minCropBoxHeight' => 100];
    public function __construct()
    {
        $this->fileSystemDisk = env('FILESYSTEM_DISK');
    }


    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
    }

    public function updateProfileInformation()
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'file' => ['nullable', 'image', 'max:10240'], // 10MB max
        ]);

        if ($this->file) {
            if ($this->fileSystemDisk == 'public') {
                $filePath = $this->file->store('avatars', 'public');

                // Delete old avatar if it exists
                if ($user->file && Storage::disk('public')->exists($user->file)) {
                    Storage::disk('public')->delete($user->file);
                }
            } else if ($this->fileSystemDisk == 's3') {
                $filePath = $this->file->storeAs('avatars', $user->id, 's3');
                $filePath = Storage::disk("s3")->url($filePath);

                if ($user->file && Storage::disk('s3')->exists($user->file)) {
                    Storage::disk('s3')->delete($user->file);
                }
            }

            User::where('id', $user->id)->update(['avatar' => $filePath]);

            $validated['file'] = $filePath;
        }

        // Update user
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        session()->flash('message', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information-form');
    }
}

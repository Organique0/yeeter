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
    public $banner;
    public $tempBanner;
    public $bio;
    private mixed $fileSystemDisk;

    public int $uuid = 12345;
    public bool $cropperModal = false;

    //cropper config
    public $config = ['guides' => false, 'aspectRatio' => 1,  'viewMode' => 1, 'minCropBoxWidth' => 100, 'minCropBoxHeight' => 100];
    //public $configBanner = ['guides' => false, 'aspectRatio' => 3,  'viewMode' => 1, 'minCropBoxWidth' => 300, 'minCropBoxHeight' =>  50, 'cropBoxResizable' => false];
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
        $this->banner = $user->banner;
        $this->bio = $user->bio;
    }

    public function updateProfileInformation()
    {

        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'avatar' => ['nullable', 'max:10240'], // 10MB max
            'bio' => ['nullable', 'string', 'max:1000'],
            //'banner' => ['nullable', 'image', 'max:10240'],
        ]);

        if ($this->avatar instanceof \Illuminate\Http\UploadedFile) {
            $extension = $this->avatar->getClientOriginalExtension();
            $filePath = null;
            if ($this->fileSystemDisk == 'public') {
                $filePath = $this->avatar->storeAs('avatars', $user->id . '.' . $extension, 'public');

                // Delete old avatar if it exists
                if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->id)) {
                    Storage::disk('public')->delete('avatars/' . $user->id);
                }
            } else if ($this->fileSystemDisk == 's3') {
                $filePath = $this->avatar->storeAs('avatars', $user->id . '.' . $extension, 's3');
                $filePath = Storage::disk("s3")->url($filePath);

                if ($user->avatar && Storage::disk('s3')->exists($filePath)) {
                    Storage::disk('s3')->delete($filePath);
                }
            }

            User::where('id', $user->id)->update(['avatar' => $filePath]);

            $validated['avatar'] = $filePath;
        };

        /*         if ($this->banner) {
            $extension = $this->banner->getClientOriginalExtension();
            $filePath = null;
            if ($this->fileSystemDisk == 'public') {
                $filePath = $this->banner->storeAs('banners', $user->id . '.' . $extension, 'public');

                // Delete old avatar if it exists
                if ($user->banner && Storage::disk('public')->exists('banners/' . $user->id)) {
                    Storage::disk('public')->delete('banners/' . $user->id);
                }
            } else if ($this->fileSystemDisk == 's3') {
                $filePath = $this->file->storeAs('banners', $user->id . '.' . $extension, 's3');
                $filePath = Storage::disk("s3")->url($filePath);

                if ($user->banner && Storage::disk('s3')->exists($filePath)) {
                    Storage::disk('s3')->delete($filePath);
                }
            }

            User::where('id', $user->id)->update(['banner' => $filePath]);

            $validated['banner'] = $filePath;
        } */

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($user->isDirty()) {
            $user->save();
            $this->dispatch('profile-updated');
        } else {
            $this->dispatch('profile-not-updated');
        }
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information-form');
    }
}

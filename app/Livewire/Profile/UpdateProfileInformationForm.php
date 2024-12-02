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
    public $bio;
    public $font;
    private mixed $fileSystemDisk;
    public $figlet;
    public $fonts = [
        ['id' => 'cybermedium', 'name' => 'cybermedium'],
        ['id' => 'larry3d', 'name' => 'larry3d'],
        ['id' => '5lineoblique', 'name' => '5lineoblique'],
        ['id' => 'alphabet', 'name' => 'alphabet'],
        ['id' => 'avatar', 'name' => 'avatar'],
        ['id' => 'banner', 'name' => 'banner'],
        ['id' => 'banner3-D', 'name' => 'banner3-D'],
        ['id' => 'barbwire', 'name' => 'barbwire'],
        ['id' => 'nancyj-underlined', 'name' => 'nancyj-underlined'],
        ['id' => 'nancyj', 'name' => 'nancyj'],
        ['id' => 'block', 'name' => 'block'],
        ['id' => 'ogre', 'name' => 'ogre'],
        ['id' => 'pawp', 'name' => 'pawp'],
        ['id' => 'chunky', 'name' => 'chunky'],
        ['id' => 'pebbles', 'name' => 'pebbles'],
        ['id' => 'computer', 'name' => 'computer'],
        ['id' => 'puffy', 'name' => 'puffy'],
        ['id' => 'rectangles', 'name' => 'rectangles'],
        ['id' => 'crawford', 'name' => 'crawford'],
        ['id' => 'rounded', 'name' => 'rounded'],
        ['id' => 'rozzo', 'name' => 'rozzo'],
        ['id' => 'sblood', 'name' => 'sblood'],
        ['id' => 'doom', 'name' => 'doom'],
        ['id' => 'graceful', 'name' => 'graceful']
    ];

    public int $uuid = 12345;
    public bool $cropperModal = false;

    //cropper config
    public $config = ['guides' => false, 'aspectRatio' => 1,  'viewMode' => 1, 'minCropBoxWidth' => 100, 'minCropBoxHeight' => 100];
    //public $configBanner = ['guides' => false, 'aspectRatio' => 3,  'viewMode' => 1, 'minCropBoxWidth' => 300, 'minCropBoxHeight' =>  50, 'cropBoxResizable' => false];
    public function __construct()
    {
        $this->fileSystemDisk = env('FILESYSTEM_DISK');
    }

    public function updatedFont()
    {
        $user = Auth::user();
        $user->update(['font' => $this->font]);
        $this->figlet = generateFiglet($this->name, $this->font);
    }


    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->avatar = $user->avatar;
        $this->font = $user->font;
        $this->bio = $user->bio;
        $this->figlet = generateFiglet($this->name, $this->font);
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

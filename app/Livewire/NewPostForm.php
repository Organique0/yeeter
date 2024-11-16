<?php

namespace App\Livewire;

use App\Models\Image;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\File as FileModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewPostForm extends Component
{
    use WithFileUploads;

    #[Rule(['files.*' => 'mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi|max:10240'])]
    public array $files = [];

    #[Rule('required')]
    public string $message = "";

    public function mount(): void {}

    public function save(): void
    {
        $this->validate();

        $post = Post::create([
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);

        if ($this->files === null) {
            $this->dispatch('postCreated');
            $this->reset(['message', 'files']);
            return;
        }

        foreach ($this->files as $file) {
            $mimeType = $file->getMimeType();
            $type = Str::startsWith($mimeType, 'image') ? 'image' : 'video';

            $path = $file->storeAs(
                'yeetImages/' . $post->id,
                $file->getClientOriginalName(),
                's3'
            );

            $url = Storage::disk('s3')->url($path);

            FileModel::create([
                'post_id' => $post->id,
                'url' => $url,
                'type' => $type,
            ]);
        }



        $this->dispatch('postCreated');
        $this->reset(['message', 'files']);
    }

    public function render(): View
    {
        return view('livewire.new-post-form');
    }
}

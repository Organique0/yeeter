<?php

namespace App\Livewire;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class NewPostForm extends Component
{
    use WithFileUploads;

    #[Validate('image|max:1024')]
    public $photo;

    #[Rule('required')]
    public string $message = "";

    public function mount(): void
    {

    }

    public function save(): void
    {

        $post = Post::create([
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);

        if ($this->photo === null) {
            $this->dispatch('postCreated');
            $this->reset(['message', 'photo']);
            return;
        }

        $path = $this->photo->storeAs(
            'yeetImages/' . $post->id,
            $this->photo->getClientOriginalName(),
            's3'
        );

        $url = Storage::disk('s3')->url($path);

        Image::create([
            'post_id' => $post->id,
            'url' => $url,
        ]);

        $this->dispatch('postCreated');
        $this->reset(['message', 'photo']);
    }

    public function render(): View
    {
        return view('livewire.new-post-form');
    }
}

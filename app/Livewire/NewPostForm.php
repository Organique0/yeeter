<?php

namespace App\Livewire;

use App\Models\Image;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\WithMediaSync;

class NewPostForm extends Component
{
    use WithFileUploads, WithMediaSync;

    #[Rule(['files.*' => 'image|max:1024'])]
    public array $files = [];

    #[Rule('required')]
    public Collection $library;

    #[Rule('required')]
    public string $message = "";

    public User $user;

    public function mount(): void
    {
        $this->user = auth()->user();

        // Load existing library metadata from your model
        $this->library = $this->user->library ?? new Collection();
    }

    public function save(): void
    {

        $post = Post::create([
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);

        foreach ($this->files as $image) {
            $path = $image->store('images', 'public');

            Image::create([
                'post_id' => $post->id,
                'url' => $path,
            ]);
        }

        // Sync files and updates library metadata
        $this->syncMedia($this->user);

        $this->dispatch('postCreated');
        $this->reset(['message', 'files']);
    }

    public function render()
    {
        return view('livewire.new-post-form');
    }
}

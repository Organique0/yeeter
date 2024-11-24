<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class DisplayPosts extends Component
{
    public $posts;
    public function mount(): void
    {
        $this->refreshPosts();
    }

    #[On('postCreated')]
    #[On('PostDeleted')]
    public function refreshPosts(): void
    {
        $this->posts = Post::with(['files', 'user'])->orderByDesc('created_at')->get();
    }

    public function deletePost($id)
    {
        deletePostDirectory($id);
        $this->dispatch("postDeleted");
    }


    public function render(): View
    {
        return view('livewire.display-posts', ['posts' => $this->posts]);
    }
}

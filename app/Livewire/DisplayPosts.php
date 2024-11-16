<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\On;

class DisplayPosts extends Component
{
    protected $listeners = ['postCreated' => '$refreshPosts'];
    public $posts;

    public function mount(): void
    {
        $this->refreshPosts();
    }

    #[On('postCreated')]
    public function refreshPosts(): void
    {
        $this->posts = Post::with(['images', 'user'])->orderByDesc('created_at')->get();
    }


    public function render(): View
    {
        return view('livewire.display-posts', ['posts' => $this->posts]);
    }
}

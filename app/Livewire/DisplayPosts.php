<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\On;

class DisplayPosts extends Component
{
    protected $listeners = ['postCreated' => '$refreshPosts'];
    public $posts;

    public function mount()
    {
        $this->refreshPosts();
    }

    #[On('postCreated')]
    public function refreshPosts()
    {
        $this->posts = Post::with(['images', 'user'])->orderBy('created_at')->get();
    }


    public function render()
    {
        return view('livewire.display-posts', ['posts' => $this->posts]);
    }
}

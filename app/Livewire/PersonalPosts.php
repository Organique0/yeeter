<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;

class PersonalPosts extends Component
{
    public $username;
    public $posts;
    public $user;

    public $renderedFiglet;


    public function mount($username): void
    {
        $this->username = $username;
        $this->user = User::where('username', $this->username)->firstOrFail();
        $this->renderedFiglet = generateFiglet($this->user->name, $this->user->font);
        $this->refreshPosts();
    }

    #[On('postCreated')]
    #[On('postDeleted')]
    public function refreshPosts(): void
    {
        $this->posts = Post::whereHas('user', function ($query) {
            $query->where('username', $this->user->username);
        })
            ->with(['files', 'user'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function deletePost($id)
    {
        deletePostDirectory($id);
        $this->dispatch("postDeleted");
    }

    public function render()
    {
        return view('livewire.personal-posts', ['posts' => $this->posts, 'figlet' => $this->renderedFiglet]);
    }
}

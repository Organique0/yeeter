<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Povils\Figlet\Figlet;

class PersonalPosts extends Component
{
    public $username;
    public $posts;
    public $user;

    public $renderedFiglet;

    public function generateFiglet($text)
    {
        $figlet = new Figlet();
        $x = $figlet
            ->setFont('cyberlarge')
            ->render($text);
        $this->renderedFiglet = $x;
    }

    public function mount($username): void
    {
        $this->username = $username;
        $this->user = User::where('username', $this->username)->firstOrFail();
        $this->generateFiglet($this->user->name);
        $this->refreshPosts();
    }

    #[On('postCreated')]
    #[On('PostDeleted')]
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

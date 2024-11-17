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

    public string $videoUrl = "";

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
                'upload-original/' . $post->id,
                $file->getClientOriginalName(),
                's3'
            );

            $url = Storage::disk('s3')->url($path);

            FileModel::create([
                'post_id' => $post->id,
                'url' => $url,
                'type' => $type,
            ]);

            $this->dispatch('postCreated');


            if ($type === 'video') {
                // Wait for the Lambda function to process the video
                // Display the video immediately
                $this->videoUrl = $url;

                // Trigger the Lambda function to compress the video
                $this->dispatch('video-uploaded', ['path' => $path, 'postId' => $post->id]);

                // Poll for the compressed video URL
                $compressed = $this->pollForCompressedVideo($path, $post->id);

                $fileModel = FileModel::where('post_id', $post->id)->where('url', $url)->first();
                $fileModel->update([
                    'url' => $compressed,
                ]);
            }

            $this->reset(['message', 'files']);
        }
    }

    private function pollForCompressedVideo(string $path, int $postId): string
    {
        // Poll S3 to check if the compressed video is available
        $compressedKey = 'yeetMedia/' . $postId . '/' . basename($path);
        $s3 = Storage::disk('s3');

        while (!$s3->exists($compressedKey)) {
            sleep(5); // Wait for 5 seconds before checking again
        }
        return $s3->url($compressedKey);
    }

    public function render(): View
    {
        return view('livewire.new-post-form');
    }
}

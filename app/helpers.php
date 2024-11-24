<?php

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

if (!function_exists('deletePostDirectory')) {
    function deletePostDirectory($id)
    {
        $post = Post::find($id);

        if ($post && $post->user_id === auth()->id()) {
            $post->delete();
        }
        if (env('FILESYSTEM_DISK') == 'public') {
            Storage::disk('public')->deleteDirectory("images/{$id}");
            Storage::disk('public')->deleteDirectory("videos/{$id}");
        } else {
            Storage::disk('s3')->deleteDirectory("yeeter-storage/yeetMedia/{$id}");
        }
    }
}

if (!function_exists('getAssetUrl')) {
    function getAssetUrl($url)
    {
        return str_contains($url, 'cloudfront.net') ? $url : asset('storage/' . $url);
    }
}

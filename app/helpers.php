<?php

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Povils\Figlet\Figlet;

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

if (!function_exists('generateFiglet')) {
    function generateFiglet($text, $font): string
    {
        $figlet = new Figlet();
        $x = $figlet
            ->setFont($font)
            ->render(ucfirst($text));

        //čarovnija
        //(ker so na koncu prazne vrstice in nevem zakaj)

        // Split the text into lines
        $lines = explode("\n", $x);

        // Remove empty lines or lines that only contain spaces
        $filtered_lines = array_filter($lines, function ($line) {
            return trim($line) !== ''; // Keep lines that are not empty or just spaces
        });

        // Rejoin the lines back into a single string
        $trimmed_text = implode("\n", $filtered_lines);
        return $trimmed_text;
    }
}

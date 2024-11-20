<?

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

if (!function_exists('deletePostDirectory')) {
    function deletePostDirectory($id)
    {
        $post = Post::find($id);

        if ($post && $post->user_id === auth()->id()) {
            $post->delete();
        }
        Storage::disk('s3')->deleteDirectory("yeeter-storage/yeetMedia/{$id}");
    }
}

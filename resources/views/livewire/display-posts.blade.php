<div>
    <h2 class="font-semibold text-xl leading-tight mt-12">
        {{ __('All posts') }}
    </h2>

    @if ($posts)
        <div class="mt-6">
            @foreach ($posts as $post)
                <div class="mb-4 p-4 border rounded-lg">
                    <h3 class="font-semibold text-lg">{{ $post->message }}</h3>
                    <p class="text-sm text-info">Posted by {{ $post->user->name }} on
                        {{ $post->created_at->setTimezone('Europe/Ljubljana')->format('M d, Y - H:i A') }}</p>
                    @if ($post->images)
                        <div class="mt-2">
                            @foreach ($post->images as $image)
                                <img src="{{ $image->url }}" alt="Post Image" class="mt-2 w-72">
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>

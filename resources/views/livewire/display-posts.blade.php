<div>
    @if ($posts)
        <div class="">
            @foreach ($posts as $post)
                <div class="border border-neutral p-2">
                    <p class="text-sm text-base-content float-end">Posted by {{ $post->user->name }} on
                        {{ $post->created_at->setTimezone('Europe/Ljubljana')->format('M d, Y - H:i A') }}
                    </p>

                    </br>


                    <h3 class="font-semibold text-lg">asdčflkhasdfčasf
                        asdfasdfčasdf
                        asdfljasčdfasd
                        fassdfčasjfas
                        dfaskdfas
                        dfasjiodfasdf
                        đšasfkjasdf

                    </h3>
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

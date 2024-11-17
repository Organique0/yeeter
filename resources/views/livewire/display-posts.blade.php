<div>
    @if ($posts)
        <div class="">
            @foreach ($posts as $post)
                <div class="border border-neutral p-2">
                    <p class="text-sm text-base-content float-end">Posted by {{ $post->user->name }} on
                        {{ $post->created_at->setTimezone('Europe/Ljubljana')->format('M d, Y - H:i A') }}
                    </p>

                    </br>

                    <p>
                        <!-- we need this function, otherwise it does not render new line characters-->
                        {!! nl2br(e($post->message)) !!}
                    </p>

                    @if ($post->files)
                        <div class="mt-2">
                            <!--
                                // here we get the data from the database, where the type is store on each file
                                // just to make it easier to decide how to display them
                                //and it works for local and s3 files
                            -->
                            @foreach ($post->files as $file)
                                @if ($file->type == 'image')
                                    @if (explode('/', $file->url)[0] == 'images')
                                        <img src="{{ asset('storage/' . $file->url) }}" alt="image" class="w-1/4">
                                    @else
                                        <img src="{{ $file->url }}" class="w-1/4">
                                    @endif
                                @endif
                                @if ($file->type == 'video')
                                    @if (explode('/', $file->url)[0] == 'videos')
                                        <video src="{{ asset('storage/' . $file->url) }}" controls
                                            class="w-1/4"></video>
                                    @else
                                        <video src="{{ $file->url }}" controls class="w-1/4"></video>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>

<div>
    @if ($posts)
        <div class="">
            @foreach ($posts as $post)
                @php
                    $post_links = [];
                    $uuid = Str::uuid();
                @endphp
                <div class="border border-neutral">
                    <p class="text-sm text-base-content float-end mt-3 mr-3">Posted by {{ $post->user->name }} on
                        {{ $post->created_at->setTimezone('Europe/Ljubljana')->format('M d, Y - H:i A') }}
                    </p>

                    </br>

                    <p class="shadow-md shadow-primary my-6 px-3 py-6 m-3 rounded-lg">
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
                                    @php
                                        $post_links[] = asset('storage/' . $file->url);
                                    @endphp
                                    {{--                                     @if (explode('/', $file->url)[0] == 'images')
                                        <img src="{{ asset('storage/' . $file->url) }}" alt="image" class="w-1/4">
                                    @else
                                        <img src="{{ $file->url }}" class="w-1/4">
                                    @endif --}}
                                @endif
                                @if ($file->type == 'video')
                                    @if (explode('/', $file->url)[0] == 'videos')
                                        <video src="{{ asset('storage/' . $file->url) }}" controls class="w-1/4"></video>
                                    @else
                                        <video src="{{ $file->url }}" controls class="w-1/4"></video>
                                    @endif
                                @endif
                            @endforeach


                            @if ($post_links)
                                <div x-data="{
                                    init() {
                                        const lightbox = new PhotoSwipeLightbox({
                                            gallery: '#gallery-{{ $uuid }}',
                                            children: 'a',
                                            showHideAnimationType: 'fade',
                                            imageClickAction: 'next',
                                            tabAction: 'next',
                                            pswpModule: PhotoSwipe,
                                            mainClass: 'pswp--custom-icon-colors',
                                        });

                                        lightbox.init();
                                    }
                                }">
                                    <div id="gallery-{{ $uuid }}" class="">

                                        <div class="flex flex-1 flex-row flex-wrap relative">
                                            @foreach ($post_links as $link)
                                                <a href="{{ $link }}" target="_blank" data-pswp-width="200"
                                                    data-pswp-height="200" class="flex items-center align-middle m-3">
                                                    <img src="{{ $link }}"
                                                        class="object-cover w-full h-auto max-w-sm  rounded-lg"
                                                        onload="this.parentNode.setAttribute('data-pswp-width', this.naturalWidth); this.parentNode.setAttribute('data-pswp-height', this.naturalHeight)" />
                                                </a>
                                            @endforeach
                                        </div>


                                    </div>
                                </div>
                            @endif
                    @endif
                </div>
            @endforeach
        </div>
    @endif

</div>

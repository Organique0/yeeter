<div>
    @if ($posts)
        <div class="mt-[4rem]">
            @foreach ($posts as $post)
                @php
                    $post_links = [];
                    $uuid = Str::uuid();
                @endphp
                <div class="mb-8 p-8 shadow-md shadow-secondary rounded-lg "> <!-- Add margin to separate posts -->
                    <p class="text-sm text-base-content float-end">
                        Posted by {{ $post->user->name }} on
                        {{ $post->created_at->setTimezone('Europe/Ljubljana')->format('M d, Y - H:i A') }}
                    </p>

                    <br> <!-- Corrected </br> to <br> -->

                    <p class=" my-6 px-3 py-6">
                        <!-- Render new line characters -->
                        {!! nl2br(e($post->message)) !!}
                    </p>

                    @if ($post->files)
                        <div class="mt-2">
                            @foreach ($post->files as $file)
                                @if ($file->type == 'image')
                                    @php
                                        $post_links[] = asset('storage/' . $file->url);
                                    @endphp
                                @elseif ($file->type == 'video')
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
                                    <div id="gallery-{{ $uuid }}">
                                        @if (count($post_links) == 1)
                                            <div class="grid grid-cols-1 gap-8">
                                                @foreach ($post_links as $link)
                                                    <a href="{{ $link }}" target="_blank" data-pswp-width="100"
                                                        data-pswp-height="100" class="block relative">
                                                        <img src="{{ $link }}"
                                                            class="h-full object-cover rounded-lg"
                                                            onload="this.parentNode.setAttribute('data-pswp-width', this.naturalWidth); this.parentNode.setAttribute('data-pswp-height', this.naturalHeight)" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if (count($post_links) == 2)
                                            <div class="grid grid-cols-2 gap-8">
                                                @foreach ($post_links as $link)
                                                    <a href="{{ $link }}" target="_blank" data-pswp-width="100"
                                                        data-pswp-height="100" class="block relative">
                                                        <img src="{{ $link }}"
                                                            class="h-full object-cover rounded-lg"
                                                            onload="this.parentNode.setAttribute('data-pswp-width', this.naturalWidth); this.parentNode.setAttribute('data-pswp-height', this.naturalHeight)" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if (count($post_links) == 3)
                                            <div class="grid grid-cols-3 gap-8">
                                                @foreach ($post_links as $link)
                                                    <a href="{{ $link }}" target="_blank" data-pswp-width="100"
                                                        data-pswp-height="100" class="block relative">
                                                        <img src="{{ $link }}"
                                                            class="h-full object-cover rounded-lg"
                                                            onload="this.parentNode.setAttribute('data-pswp-width', this.naturalWidth); this.parentNode.setAttribute('data-pswp-height', this.naturalHeight)" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if (count($post_links) >= 4)
                                            <div class="grid grid-cols-4 gap-8">
                                                @foreach ($post_links as $link)
                                                    <a href="{{ $link }}" target="_blank" data-pswp-width="100"
                                                        data-pswp-height="100" class="block relative">
                                                        <img src="{{ $link }}"
                                                            class="h-full object-cover rounded-lg"
                                                            onload="this.parentNode.setAttribute('data-pswp-width', this.naturalWidth); this.parentNode.setAttribute('data-pswp-height', this.naturalHeight)" />
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

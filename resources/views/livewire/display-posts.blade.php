<div>
    @if ($posts)
        <div class="mt-[4rem]">
            @foreach ($posts as $post)
                @php
                    $uuid = Str::uuid();
                    $numFiles = count($post->files);
                @endphp
                <div class="mb-8 p-8 shadow-md shadow-secondary rounded-lg">
                    <div class="flex items-center">
                        <p class="font-extrabold">
                            {{ $post->user->name }}
                            <a href="u/{{ $post->user->username }}" class="opacity-50">
                                {{ '@' . $post->user->username }}
                            </a>
                        <div class="px-1 text-2xl font-extrabold">·</div>
                        <p class="font-extralight">
                            {{ $post->created_at->setTimezone('Europe/Ljubljana')->diffForHumans() }}
                        </p>

                        @if ($post->user_id == auth()->id())
                            <div class="ml-auto">
                                <x-mary-button label="Delete"
                                    class="bg-transparent border border-warning hover:bg-warning hover:text-warning-content h-1"
                                    wire:click='deletePost({{ $post->id }})' />
                            </div>
                        @endif
                    </div>

                    <p class="mb-6">
                        {!! nl2br(e($post->message)) !!}
                    </p>

                    @if ($post->files)
                        <div class="mt-2">
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
                                <div id="gallery-{{ $uuid }}" class="flex flex-wrap gap-2">
                                    @foreach ($post->files as $file)
                                        @if ($file->type == 'image')
                                            @php
                                                // $numFiles % 2 == 1 && $loop->last ? 'w-full' : 'w-1/2'
                                                // ok, it finally works the way I wanted it to
                                                // če je zadnji vpis v post files potem gre čez 2 stolpca.
                                                // ampak to upošteva samo, če je liho število vnosov
                                                // drugače bi, če imamo 2 zapisa, dal enega čez pol vrstice in drugega v celotno drugo vrstico
                                                // če je samo en zapis se ravno prav izzide, ker je liho in zadnji vnos

                                                // w-[calc(50%-0.25rem)]
                                                // I don't know how to do this properly, so I always just do it like this
// when using columns it's fine, but with flex wrap
                                                // when you have 2 50% items, it takes more space than 100%
                                                // So I just substract the gap from the width
                                            @endphp
                                            <a href="{{ env('FILESYSTEM_DISK') == 'public' ? asset('storage/' . $file->url) : $file->url }}"
                                                target="_blank" data-pswp-width="100" data-pswp-height="100"
                                                class="relative flex items-center justify-center align-middle {{ $numFiles % 2 == 1 && $loop->last ? 'w-full' : 'w-[calc(50%-0.25rem)]' }}">
                                                <img src="{{ env('FILESYSTEM_DISK') == 'public' ? asset('storage/' . $file->url) : $file->url }}"
                                                    class="object-cover rounded-lg aspect-video"
                                                    onload="this.parentNode.setAttribute('data-pswp-width', this.naturalWidth); this.parentNode.setAttribute('data-pswp-height', this.naturalHeight)" />
                                            </a>
                                        @elseif ($file->type == 'video')
                                            <a href="{{ env('FILESYSTEM_DISK') == 'public' ? asset('storage/' . $file->url) : $file->url }}"
                                                target="_blank" data-pswp-width="100" data-pswp-height="100"
                                                class="relative flex items-center justify-center align-middle {{ $numFiles % 2 == 1 && $loop->last ? 'w-full' : 'w-[calc(50%-0.25rem)]' }}">
                                                <video
                                                    src="{{ env('FILESYSTEM_DISK') == 'public' ? asset('storage/' . $file->url) : $file->url }}"
                                                    controls class="object-cover rounded-lg"></video>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

<div class="mx-auto p-6 shadow-md shadow-primary rounded-lg mt-[4rem]">
    <h1 class="text-2xl font-semibold text-inherit mb-4">{{ __('Create a new post') }}</h1>
    <x-mary-form id="new-post-form" class="space-y-4">

        <div class="flex items-start space-x-4">
            <div class="flex-1">
                <div id="message" class="cursor-text p-1 focus:outline-none min-h-11 text-sm opacity-90" role="textbox"
                    contenteditable spellcheck wire:ignore.self>
                </div>
                @if ($files)
                    <div class="mt-4">
                        <!--
                            // the file is not store in the database yet, so we cannot just see the type from there
                            // we need to go through the files that are stored in a temporary folder and check the type of each one
                        }}-->
                        @foreach ($files as $file)
                            @if (Str::startsWith($file->getMimeType(), 'image'))
                                <img src="{{ $file->temporaryUrl() }}" alt="image" class="w-1/4">
                            @endif
                            @if (Str::startsWith($file->getMimeType(), 'video'))
                                <video src="{{ $file->temporaryUrl() }}" controls class="w-1/4"></video>
                            @endif
                        @endforeach
                    </div>
                @endif

                <div>{{ $message }}</div>
                @error('message')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                {{--  <input type="file" id="photo" wire:model="photo" accept="image/*"
                    class="block text-sm text-inherit file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold "> --}}
                <x-mary-file wire:model="files" label="Upload an image or video" />
                @error('photo')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>

            <x-mary-button type="submit"
                class="btn-primary text-primary-content text-xl font-extrabold">{{ __('Yeet') }}</x-mary-button>
        </div>
    </x-mary-form>
</div>

{{--
we need to make a custom form submit because for some reason setting
the value of a textarea with javascript doesn't work with livewire.
I don't know how to make it detect that the value of a textarea has changed programatically.
If I enter the data in it manually, it works fine.
--}}
@push('scripts')
    <script>
        document.addEventListener('livewire:navigated', function() {
            const messageDiv = document.getElementById('message');
            const form = document.getElementById('new-post-form');

            if (messageDiv && form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    let messageContent = messageDiv.innerText.trim();

                    // sets the message variable in the server with the contents of the message div
                    @this.
                    set('message', messageContent);
                    // call the save method on the server
                    @this.
                    call('save');
                });
            }

            const placeholderMessage = "Enter a message"

            messageDiv.innerText = placeholderMessage;
            messageDiv.addEventListener('focus', function(event) {
                messageDiv.innerText = "";
            })
            messageDiv.addEventListener('blur', function(event) {
                messageDiv.innerText = placeholderMessage;
            })
        });
    </script>
@endpush

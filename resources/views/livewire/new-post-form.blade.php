<div class="mx-auto p-6 shadow-md shadow-primary rounded-lg mt-[4rem] relative">
    <x-mary-form id="new-post-form" class="space-y-4">

        <div class="flex items-start space-x-4">
            <div class="flex-1">
                <!-- editable div element. without the wire:ignore it resets the message after uploading a file-->
                <div id="message"
                    class="cursor-text p-1 focus:outline-none min-h-11 empty:before:opacity-35 font-extrabold text-lg  empty:before:content-['Input\0020your\0020message\0020here']"
                    role="textbox" contenteditable spellcheck wire:ignore>
                </div>
                <div class="flex gap-3 border-t pt-6 items-center">
                    <x-mary-dropdown>
                        <x-slot:trigger>
                            <x-mary-button icon="o-face-smile"
                                class="btn-sm btn-circle text-primary hover:bg-primary/15" />
                        </x-slot:trigger>
                        <emoji-picker wire:click.stop></emoji-picker>
                    </x-mary-dropdown>


                    <x-mary-button icon="o-photo" class="btn-sm btn-circle text-primary hover:bg-primary/15"
                        @click="document.getElementById('file-input').click()" />

                    <x-mary-button type="submit"
                        class="btn-primary text-primary-content text-xl font-extrabold ml-auto">{{ __('Yeet') }}</x-mary-button>
                </div>
                {{--                 <div id="grid"></div> --}}

                @if ($files)
                    <!--
                            // the file is not store in the database yet, so we cannot just see the type from there
                            // we need to go through the files that are stored in a temporary folder and check the type of each one

                            //snap-x is horizontal snapping
                            //snap-mandatory is a type of snapping
                        }}-->
                    <div class="flex overflow-x-auto gap-8 snap-x snap-mandatory">
                        @foreach ($files as $id => $file)
                            <div class="relative flex-shrink-0 snap-center">
                                @if (Str::startsWith($file->getMimeType(), 'image'))
                                    <img src="{{ $file->temporaryUrl() }}"
                                        class="object-cover rounded-lg aspect-square w-64 h-64" />
                                @endif
                                @if (Str::startsWith($file->getMimeType(), 'video'))
                                    <video src="{{ $file->temporaryUrl() }}" controls
                                        class="object-cover rounded-lg aspect-square w-64 h-64"></video>
                                @endif

                                <x-mary-button icon="o-x-mark" class="btn-circle absolute top-2 right-2"
                                    wire:click="delete({{ $id }})" />
                            </div>
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
                <input id="file-input" type="file" x-ref="file" class="hidden" wire:model="files">
                @error('photo')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>


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
            //we add this to make tailwind empty: work


            const form = document.getElementById('new-post-form');

            if (messageDiv && form) {
                messageDiv.innerText = "";
                form.addEventListener('submit', function(event) {
                    event.preventDefault();

                    let messageContent = messageDiv.innerText.trim();

                    // sets the message variable in the server with the contents of the message div
                    @this.
                    set('message', messageContent);
                    // call the save method on the server
                    @this.
                    call('save');

                    // clear the message div
                    messageDiv.innerText = "";
                });
                //when you click ouside the div and there is no text inputed, set it to empty string
                //this is because the browser randomly adds some content in a contenteditable div
                //and this hidden things stay in the div and so breaking the empty: property
                messageDiv.addEventListener('blur', function(event) {
                    if (message.innerText.trim() === '') {
                        messageDiv.innerText = "";
                    }
                });

                document.querySelector('emoji-picker')
                    .addEventListener('emoji-click', event => messageDiv.innerText += event.detail.unicode);
                const style = document.createElement('style');
                style.textContent = `
                .pad-top  {
                    opacity: 0;
                }
                .skintone-button-wrapper {
                    display: none;
                }
                .search-row{
                    padding-inline-end: var(--emoji-padding);
                }
            `;
                const picker = document.querySelector('emoji-picker');
                picker.onClick
                picker.shadowRoot.appendChild(style);
            }





        });
    </script>
@endpush

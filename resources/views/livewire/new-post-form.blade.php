<div class="mx-auto p-6 border-x border-neutral">
    <h1 class="text-2xl font-semibold text-inherit mb-4">{{ __('Create a new post') }}</h1>
    <x-mary-form wire:submit.prevent='save' class="space-y-4">

        <div class="flex items-start space-x-4">
            <div class="flex-1">
                <div class="cursor-text p-1 focus:outline-none h-12" role="textbox" contenteditable spellcheck>
                    @if ($photo)
                        <div class="mt-4">
                            <img src="{{ $photo->temporaryUrl() }}" alt="Image Preview"
                                class="mt-2 h-40 rounded-lg shadow-md">
                        </div>
                    @endif
                </div>
                @error('message')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="file" id="photo" wire:model="photo" accept="image/*"
                    class="block text-sm text-inherit file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold ">

                @error('photo')
                    <span class="text-sm text-error">{{ $message }}</span>
                @enderror
            </div>

            <x-mary-button type="submit"
                class="btn-primary text-primary-content text-xl font-extrabold">{{ __('Yeet') }}</x-mary-button>
        </div>
    </x-mary-form>
</div>

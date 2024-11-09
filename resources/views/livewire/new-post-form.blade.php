<div class="">
    <h1>{{ __('Create a new post') }}</h1>
    <x-mary-form wire:submit='save'>
        <x-mary-input label="message" wire:model="message" />

        <x-mary-file wire:model="photo" label="Post image" hint="Any image format" accept="image/" />

        <x-mary-button type="submit">{{ __('Submit') }}</x-mary-button>
    </x-mary-form>
</div>

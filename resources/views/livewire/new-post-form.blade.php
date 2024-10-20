<div class="">
    <h1>{{ __('Create a new post') }}</h1>
    <x-mary-form wire:submit='save'>
        <x-mary-input label="message" wire:model="message" />

        <x-mary-image-library wire:model="files" wire:library="library" :preview="$library" label="{{ __('Images') }}"
            hint="{{ __('Max 100Kb') }}" />

        <x-mary-button type="submit">{{ __('Submit') }}</x-mary-button>
    </x-mary-form>
</div>

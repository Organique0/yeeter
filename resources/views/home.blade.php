<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl  leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <livewire:new-post-form />
    <livewire:display-posts />

</x-app-layout>

<div>
    @if ($type === 'drawer')
        <div>
            <x-mary-drawer wire:model="showDrawer" title="{{ __('Theme') }}" subtitle="{{ __('Choose a theme') }}"
                separator with-close-button close-on-escape class="w-11/12 lg:w-1/5">

                <x-mary-select data-choose-theme :options="$formattedThemes" option-value="value" option-label="name" />
            </x-mary-drawer>

            <x-mary-button label="{{ __('Theme') }}" @click="$wire.showDrawer = true" class="fixed bottom-16" />
        </div>
    @elseif ($type === 'select')
        <div>
            <x-mary-select data-choose-theme :options="$formattedThemes" option-value="value" option-label="name" />
        </div>
    @else
        <p>{{ __('No type specified') }}</p>
    @endif
</div>

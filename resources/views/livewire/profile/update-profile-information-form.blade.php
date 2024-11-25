<section>
    <header>
        <h2 class="text-lg font-medium ">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm ">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        {{-- <div>
            @if ($banner)
                <x-mary-file wire:model="banner" accept="image/png, image/jpeg" crop-after-change :crop-config='$configBanner'
                    change-text="{{ __('Change') }}" crop-text="{{ __('crop') }}"
                    crop-title-text="{{ __('Crop Image') }}" crop-cancel-text="{{ __('Cancel') }}"
                    crop-save-text="{{ __('crop') }}">
                    <img src="{{ getAssetUrl($banner) }}" class="h-40 w-full object-cover" />
                </x-mary-file>
            @elseif ($tempBanner)

                When use upload a banner, the $tempBanner url get a value immediately. So we can show a preview.
                We cannot use $banner because you need to apply temporaryUrl function to get the url.
                We diplay the first one, if there is a $banner but before we submit the form, we need to use
                the temporaryUrl function to get the url. So we keep the $banner as null until we submit the form.
                Then when the users refreshes the page, the $banner will load from database anyways.


                <x-mary-file wire:model="banner" accept="image/png, image/jpeg" crop-after-change :crop-config='$config'
                    change-text="{{ __('Change') }}" crop-text="{{ __('crop') }}"
                    crop-title-text="{{ __('Crop Image') }}" crop-cancel-text="{{ __('Cancel') }}"
                    crop-save-text="{{ __('crop') }}">
                    <img src="{{ $tempBanner->temporaryUrl() }}" class="h-40 w-full object-cover" />
                </x-mary-file>
            @endif


        </div> --}}
        <div>
            <x-mary-file wire:model="avatar" accept="image/png, image/jpeg" crop-after-change :crop-config='$config'
                change-text="{{ __('Change') }}" crop-text="{{ __('crop') }}" crop-title-text="{{ __('Crop Image') }}"
                crop-cancel-text="{{ __('Cancel') }}" crop-save-text="{{ __('crop') }}">
                <img src="{{ getAssetUrl($avatar) }}" class="h-40 rounded-full fill" />
            </x-mary-file>
        </div>
        <div>
            <x-mary-textarea label="{{ __('Bio') }}" wire:model="bio" id="bio" name="bio"
                class="mt-1 block w-full" inline hint="Max 1000 characters" rows="5" />
        </div>
        <div>
            <x-mary-input label="{{ __('Name') }}" wire:model="name" id="name" name="name" type="text"
                class="mt-1 block w-full" required autofocus autocomplete="name" />
        </div>

        <div>
            <x-mary-input label="{{ __('Email') }}" wire:model="email" id="email" name="email" type="email"
                class="mt-1 block w-full" required autocomplete="username" />

            @if (auth()->user() instanceof MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-mary-button class="btn-primary" type="submit">{{ __('Save') }}</x-mary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
            <x-action-message class="me-3" on="profile-not-updated">
                {{ __('Nothing to change.') }}
            </x-action-message>
        </div>
    </form>
</section>

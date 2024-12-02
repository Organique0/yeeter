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
        <div class="flex justify-center">
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


    <div class="mt-12">
        <pre class="text-md md:text-xl lg:text-3xl text-primary text-center" style="font-weight: 900">
{{ $figlet }}
        </pre>


        <x-mary-select label="Select figlet font" :options="$fonts" wire:model.live="font" />
    </div>

</section>

<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('home', absolute: false), navigate: true);
};

?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Email Address -->
        <div>
            <x-mary-input label="{{ __('Email') }}" wire:model='form.email' id="email" type="email" name="email"
                required autofocus autocomplete="email" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-mary-input label="{{ __('Password') }}" wire:model="form.password" id="password"
                class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="flex justify-between mt-4">
            <x-mary-checkbox label="{{ __('Remember me') }}" wire:model="form.remember" id="remember"
                name="remember" />
            <a class="underline text-sm " href="{{ route('register') }}" wire:navigate>
                {{ __('Register') }}
            </a>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm  rounded-md focus:outline-none" href="{{ route('password.request') }}"
                    wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-mary-button class="ms-3 btn-primary" type="submit">
                {{ __('Log in') }}
            </x-mary-button>
        </div>
    </form>
</div>

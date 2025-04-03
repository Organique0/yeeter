<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'surname' => '',
    'username' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'surname' => ['required', 'string', 'max:255'],
    'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    $user = User::create($validated);

    event(new Registered($user));

    Auth::login($user);

    $this->redirect(route('home', absolute: false), navigate: true);
};

?>

<div>
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-mary-input label="{{ __('Name') }}" wire:model="name" id="name" class="block mt-1 w-full"
                type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Surname -->
        <div class="mt-4">
            <x-mary-input label="{{ __('Surname') }}" wire:model="surname" id="surname" class="block mt-1 w-full"
                type="text" name="surname" required autofocus autocomplete="surname" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <x-mary-input label="{{ __('Username') }}" wire:model="username" id="username" class="block mt-1 w-full"
                type="text" name="username" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-mary-input label="{{ __('Email') }}" wire:model="email" id="email" class="block mt-1 w-full"
                type="email" name="email" required autocomplete="email" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-mary-input label="{{ __('Password') }}" wire:model="password" id="password" class="block mt-1 w-full"
                type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-mary-input label="{{ __('Confirm Password') }}" wire:model="password_confirmation"
                id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm " href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-mary-button class="ms-4 btn-primary" type="submit">
                {{ __('Register') }}
            </x-mary-button>
        </div>
    </form>
</div>

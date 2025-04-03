<nav class="flex flex-1 justify-between border-b border-primary h-14">
    <a href="/" wire:navigate>
        <x-application-logo />
    </a>

    @auth
        <a href="{{ url('/home') }}" wire:navigate
            class="h-full flex items-center p-5 transition ease-in-out delay-75 hover:brightness-110 hover:text-secondary">
            Home
        </a>
    @else
        <div class="flex">
            <a href="{{ route('login') }}" wire:navigate
                class="h-full flex items-center p-5 transition ease-in-out delay-75 hover:brightness-110 hover:text-secondary">
                Log in
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" wire:navigate
                    class="h-full flex items-center p-5 transition ease-in-out delay-75 hover:brightness-110 border-l border-l-primary hover:text-secondary hover:border-b-secondary">
                    Register
                </a>
            @endif
        </div>
    @endauth
</nav>

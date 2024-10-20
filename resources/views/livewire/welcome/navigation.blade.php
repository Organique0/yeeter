<nav class="flex flex-1 justify-between border border-primary h-14">
    <a href="/" wire:navigate>
        <x-application-logo class="block h-full w-auto fill-primary" />
    </a>

    @auth
        <a href="{{ url('/home') }}"
            class="h-full bg-primary flex items-center p-3 transition ease-in-out delay-75 hover:brightness-110">
            Home
        </a>
    @else
        <div class="flex">
            <a href="{{ route('login') }}"
                class="h-full bg-primary flex items-center p-3 transition ease-in-out delay-75 hover:brightness-110">
                Log in
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="h-full bg-primary flex items-center p-3 transition ease-in-out delay-75 hover:brightness-110 border-l-2">
                    Register
                </a>
            @endif
        </div>
    @endauth
</nav>

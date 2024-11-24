<div>


    <div class="p-4 rounded-lg shadow-md mb-4">
        <div class="items-center space-x-4">
            {{--             <div class="rounded-full bg-primary w-32 h-32 flex items-center align-middle justify-center">
                @if ($user->avatar)
                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $user->avatar }}">
                @else
                    <x-default-user class="" />
                @endif
            </div> --}}


            <div>
                <!--- DO NOT INDENT THE CONTENTS OF THIS!-->
                <pre class="text-3xl text-secondary text-center">
{{ $figlet }}
        </pre>
            </div>


        </div>
    </div>

    <livewire:display-posts>


</div>

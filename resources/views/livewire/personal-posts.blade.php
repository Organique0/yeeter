<div>


    <div class="p-4 rounded-lg shadow-md mb-4">
        <div class="items-center">
            <div
                class="rounded-full  flex items-center
            align-middle justify-center m-auto w-20 md:w-28 lg:w-36">
                <img class=" rounded-full object-cover" src="{{ getAssetUrl($user->avatar) }}">
            </div>

            <div class="">
                <!--- DO NOT INDENT THE CONTENTS OF THIS!-->
                <pre class="text-md md:text-xl lg:text-xl text-primary text-center" style="font-weight: 900">
{{ $figlet }}
        </pre>
                <p class="text-xl opacity-50 mb-2">{{ '@' . $user->username }}</p>
                <p class="mb-2"> {!! nl2br(e($user->bio)) !!}</p>

                <p class="text-xl opacity-50"><x-mary-icon name="c-calendar-days" /> Joined
                    {{ $user->created_at->format('F Y') }}</p>
            </div>


        </div>
    </div>

    <livewire:display-posts>


</div>

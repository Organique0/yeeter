<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yeeter</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anta&display=swap" rel="stylesheet">

    <!-- themes -->


    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src={{ asset('js/theme.js') }}></script>

</head>

<body class="antialiased">
    <div>
        <header>
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
        </header>

        <livewire:change-themes type="drawer" />
    </div>

    <div class="text-center">
        <div class="h-[50%] flex justify-center items-center mt-44">
            <x-application-logo-text />

        </div>
        <h1 class="text-9xl">Yeeter</h1>

        <div>
            <x-mary-button label="Yeet something on the internet"
                class="bg-transparent outline outline-secondary text-secondary text-xl font-light mt-9 hover:bg-transparent hover:scale-110 hover:ring-4 hover:ring-secondary transtition-all"
                link="/home" />
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Yeeter</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

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
        <!--ROCKET -->
        <div class="mt-16">
            <svg class="stroke-secondary mx-auto rotate-12" width="500" height="500" version="1.1"
                stroke="inherit" id="svg48" sodipodi:docname="rocket_space.svg"
                inkscape:version="1.4 (e7c3feb100, 2024-10-09)"
                xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
                xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns="http://www.w3.org/2000/svg"
                xmlns:svg="http://www.w3.org/2000/svg">
                <defs id="defs48" />
                <g id="rocket">
                    <polygon points="230,150 270,150 250,50 " stroke="inherit" fill="none" stroke_width="2"
                        id="polygon1" class="stroke-primary fill-primary" />
                    <rect x="230" y="150" width="40" height="150" stroke="inherit" fill="none" stroke_width="2"
                        id="rect1" class="fill-secondary" />
                    <polygon points="220,320 230,320 230,300 " stroke="inherit" fill="none" stroke_width="2"
                        id="polygon2" class="fill-secondary" />
                    <polygon points="280,320 270,320 270,300 " stroke="inherit" fill="none" stroke_width="2"
                        id="polygon3" class="fill-secondary" />
                    <line x1="245" y1="320" x2="240" y2="400" stroke="inherit" stroke_width="1"
                        id="line3" class="stroke-primary" />
                    <line x1="255" y1="320" x2="260" y2="400" stroke="inherit" stroke_width="1"
                        id="line4" class="stroke-primary" />
                    <line x1="250" y1="320" x2="250" y2="400" stroke="inherit" stroke_width="1"
                        id="line5" class="stroke-primary" />
                </g>
                <path d="m 220,320 q -10,-10 -20,0 -10,10 20,0" stroke="inherit" fill="none" stroke_width="1"
                    id="path47" class="fill-secondary" />
                <path d="m 280,320 q 10,-10 20,0 10,10 -20,0" stroke="inherit" fill="none" stroke_width="1"
                    id="path48" class="fill-secondary" />
            </svg>
        </div>


        <div class="mt-[-3em]">
            <h1 class="text-primary font-extrabold tracking-wider text-9xl">Yeeter</h1>
            <h2 class="text-secondary font-bold italic text-3xl">"Yeet something on the internet!"</h2>
        </div>

    </div>
</body>

</html>

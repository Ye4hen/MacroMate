<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <title>@yield("title") — MacroMate</title>
        @stack("styles")
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>
    <body class="bg-mm-dark min-h-screen">
        <main
            class="container mx-auto py-6 px-3 min-h-screen flex flex-col items-center justify-center gap-y-5"
        >
            @include("components.flash")
            @include("components.logo", ["height" => 150, "width" => 150])
            @yield("content")
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    setTimeout(() => {
                        flash.classList.add('opacity-0');
                        setTimeout(() => flash.remove(), 500); // remove after fade out
                    }, 5000); // 5s
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @stack("scripts")
    </body>
</html>

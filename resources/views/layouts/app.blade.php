<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <link rel="manifest" href="/manifest.json" />
        <meta name="theme-color" content="#f97316" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-title" content="MacroMate" />
        <link rel="apple-touch-icon" href="/icons/icon-192.png" />
        <title>@yield("title") — MacroMate</title>
        @stack("styles")
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body class="bg-mm-dark min-h-screen text-white flex">
        @include("components.mm-side-bar")

        <div
            class="container mx-auto py-6 pl-20 pr-4 flex flex-col justify-between min-h-full"
        >
            <main>
                @include("components.flash")
                <div class="max-w-xl mx-auto">
                    @yield("content")
                </div>
            </main>

            <footer class="text-center py-6 text-sm text-gray-500">
                © {{ date("Y") }}
            </footer>
        </div>
        <div id="modal-container"></div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    setTimeout(() => {
                        flash.classList.add('opacity-0');
                        setTimeout(() => flash.remove(), 500);
                    }, 5000);
                }

                window.showGlobalLoader = function () {
                    if (document.getElementById('mm-loading-overlay')) return;
                    const overlay = document.createElement('div');
                    overlay.id = 'mm-loading-overlay';
                    overlay.className =
                        'fixed inset-0 bg-black/60 z-[9999] flex items-center justify-center';
                    overlay.innerHTML = `
                  <div role="status" aria-live="polite" class="flex items-center gap-3">
                    <i class="fa-solid fa-spinner fa-spin text-white text-4xl"></i>
                  </div>
                `;
                    document.body.appendChild(overlay);
                };

                const forms = document.querySelectorAll('.form-with-loader');

                if (forms.length) {
                    forms.forEach((form) => {
                        form.addEventListener('submit', () => {
                            showGlobalLoader();
                        });
                    });
                }
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
        @stack("scripts")
        <script>
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js');
            }
        </script>
    </body>
</html>

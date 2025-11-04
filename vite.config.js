import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig(({ mode }) => {
    const is_dev = mode === "development";

    return {
        plugins: [
            laravel({
                input: [
                    "resources/css/app.css",
                    "resources/js/app.js",
                ],
                refresh: true,
            }),
            tailwindcss(),
        ],
        resolve: {
            alias: {
                "@": path.resolve(__dirname, "resources"),
            },
        },
        server: {
            host: "0.0.0.0",
            port: 1488,
            strictPort: true,

            hmr: {
              host: "host.docker.internal",
              protocol: "ws"
            }
        },
        build: {
            outDir: "public/build",
            emptyOutDir: true,
        },
        css: {
            devSourcemap: is_dev,
        },
    };
});

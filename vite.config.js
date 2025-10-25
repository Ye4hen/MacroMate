import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import legacy from "@vitejs/plugin-legacy";
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
            legacy({
                targets: ["defaults", "not IE 11"],
                additionalLegacyPolyfills: ["regenerator-runtime/runtime"],
            }),
            tailwindcss(),
        ],
        resolve: {
            alias: {
                "@": path.resolve(__dirname, "resources"),
            },
        },
        server: {
            host: "127.0.0.1",
            port: 1488,
            strictPort: true,

            hmr: {
                host: "127.0.0.1",
                protocol: "ws",
            },
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

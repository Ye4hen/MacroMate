const CACHE = "macromate-v1";
const OFFLINE_ASSETS = ["/", "/offline.html"];

self.addEventListener("install", (e) => {
    e.waitUntil(
        caches.open(CACHE).then((cache) => cache.addAll(OFFLINE_ASSETS)),
    );
});

self.addEventListener("fetch", (e) => {
    e.respondWith(fetch(e.request).catch(() => caches.match("/offline.html")));
});

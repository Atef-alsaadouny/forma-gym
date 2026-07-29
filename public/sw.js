const CACHE = 'forma-gym-v2';

const PRECACHE_URLS = [
    '/',
    '/?locale=ar',
    '/?locale=en',
    '/about',
    '/crossfit',
    '/crossfit?locale=ar',
    '/crossfit?locale=en',
    '/faq',
    '/faq?locale=ar',
    '/faq?locale=en',
    '/rules',
    '/rules?locale=ar',
    '/rules?locale=en',
    '/subscription/register',
    '/subscription/register?locale=ar',
    '/subscription/register?locale=en',
    '/subscription/lookup',
    '/subscription/lookup?locale=ar',
    '/subscription/lookup?locale=en',
    '/offline',
];

const ASSET_EXTENSIONS = /\.(js|css|png|jpg|jpeg|gif|svg|ico|webp|avif|woff2?|ttf|eot|mp4|webm)(\?.*)?$/;

self.addEventListener('install', (event) => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE).then((cache) => cache.addAll(PRECACHE_URLS))
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.filter((k) => k !== CACHE).map((k) => caches.delete(k)))
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    if (url.origin !== location.origin) return;

    if (url.pathname.startsWith('/admin')) {
        event.respondWith(fetch(request).catch(() => new Response(null, { status: 503 })));
        return;
    }

    const isDocument = request.mode === 'navigate' || request.destination === 'document';
    const isAsset = ASSET_EXTENSIONS.test(url.pathname);

    if (isAsset) {
        event.respondWith(
            caches.match(request).then((cached) => cached || fetch(request).then((response) => {
                const clone = response.clone();
                caches.open(CACHE).then((cache) => cache.put(request, clone));
                return response;
            }))
        );
        return;
    }

    if (isDocument) {
        event.respondWith(
            fetch(request).then((response) => {
                const clone = response.clone();
                caches.open(CACHE).then((cache) => cache.put(request, clone));
                return response;
            }).catch(() => caches.match(request).then((cached) => cached || caches.match('/offline')))
        );
        return;
    }

    event.respondWith(
        fetch(request).catch(() => caches.match(request))
    );
});

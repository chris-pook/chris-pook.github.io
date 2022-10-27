var CACHE_NAME = 'absolutecommerce-v2';
var urlsToCache = [
    '/',
    '/services',
    '/extensions',
    '/blog',
    '/contact',
    '/terms-and-conditions',
    '/css/main.css',
    '/js/main.js'
];

self.addEventListener('install', function(e) {
    e.waitUntil(
        caches.open(CACHE_NAME).then(function(cache) {
            return cache.addAll(
                urlsToCache
            );
        })
    );
});

// Network first cache strategy
self.addEventListener('fetch', function(event) {
    event.respondWith(
        fetch (event.request).catch(function() {
            return caches.match(event.request);
        })
    );
});

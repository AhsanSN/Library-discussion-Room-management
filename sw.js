self.addEventListener('install', function(e) {
 e.waitUntil(
   caches.open('anomoz-library').then(function(cache) {
     return cache.addAll([
       '/',
       'index.php',
       'dashboard.php',
       'history.php',
     ]);
   })
 );
});
self.addEventListener('fetch', function(event) {

});
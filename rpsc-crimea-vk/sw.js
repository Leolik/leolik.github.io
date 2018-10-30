importScripts('https://sukochev.name/rpsc-crimea-vk/sw-toolbox.js');
toolbox.precache(["/index.html","/style.css","/js/*.js","/*.png","/*.svg","/favicon.ico"]);
toolbox.router.get('*', toolbox.networkFirst, {
networkTimeoutSeconds: 3});

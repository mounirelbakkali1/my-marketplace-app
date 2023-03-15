/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';

window.Pusher = Pusher;
Pusher.logToConsole = true;

/*
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.PUSHER_APP_CLUSTER
});
*/
console.log('key: ',import.meta.env.VITE_PUSHER_APP_KEY)
let pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: 'eu'
});

let channel = pusher.subscribe('public.playground.1');
channel.bind('playground', function(data) {
    console.log(JSON.stringify(data));
});

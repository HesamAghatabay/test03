import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: "pusher",
  key: "your-app-key",
  cluster: "mt1",
  forceTLS: true,
});

echo.channel("chat")
    .listen("MessageSent", (e) => {
        console.log("New message: ", e.message);
        // اینجا می‌تونی پیام رو به لیست اضافه کنی
    });

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

const echo = new Echo({
  broadcaster: "pusher",
  key: "435e85b5419cbd8ed3d8", // همون PUSHER_APP_KEY
  cluster: "ap2",             // همونی که توی .env داری
  forceTLS: true,
});

export default echo;

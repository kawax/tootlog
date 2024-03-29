import lodash from 'lodash';
import 'bootstrap';
import axios from 'axios';

window._ = lodash;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import '@fortawesome/fontawesome-free/scss/fontawesome.scss'
import '@fortawesome/fontawesome-free/scss/regular.scss'
import '@fortawesome/fontawesome-free/scss/solid.scss'
import '@fortawesome/fontawesome-free/scss/v4-shims.scss'

import '../sass/app.scss';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'
//
// window.io = require('socket.io-client')
//
// window.Pusher = require('pusher-js');
//
// window.Echo = new Echo({
//     broadcaster: 'socket.io',
//     host: 'http://localhost:6001'
// });
//
// window.Echo.channel('*')
//     .listen('*', (data) => {
//         console.log(data)
//     });

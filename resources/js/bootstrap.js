import lodash from 'lodash';
import popper from 'popper.js';
import jquery from 'jquery';
import 'bootstrap';
import axios from 'axios';

window._ = lodash;
window.Popper = popper.default;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.$ = window.jQuery = jquery;
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import 'font-awesome/scss/font-awesome.scss';

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

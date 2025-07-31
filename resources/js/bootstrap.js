// resources/js/bootstrap.js

window._ = require('lodash');
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}

import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

if (process.env.MIX_PUSHER_APP_KEY && token) {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        forceTLS: true,
        auth: {
            headers: {
                'X-CSRF-TOKEN': token.content,
            },
        },
    });
} else {
    console.warn('Pusher keys or CSRF token not found. Real-time features will be disabled.');
}
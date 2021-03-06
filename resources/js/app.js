require('./bootstrap')

import { createApp } from 'vue'
import UserTimeline from './components/UserTimeline'
import twemoji from 'twemoji'

createApp({
    components: {
        'tt-user-timeline': UserTimeline,
    },
}).mount('#app')

twemoji.parse(document.body)

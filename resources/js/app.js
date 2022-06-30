import'./bootstrap';
import { createApp } from 'vue';
import UserTimeline from './components/UserTimeline.vue';
import twemoji from 'twemoji';

createApp({
    components: {
        'tt-user-timeline': UserTimeline,
    },
}).mount('#app')

twemoji.parse(document.body)

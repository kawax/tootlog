import'./bootstrap';
import { createApp } from 'vue';
import UserTimeline from './components/UserTimeline.vue';
import twemoji from 'twemoji';

const app = createApp({});

app.component('tt-user-timeline', UserTimeline);

app.mount('#app');

twemoji.parse(document.body);

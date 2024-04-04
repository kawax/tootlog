import'./bootstrap';
import { createApp } from 'vue';
import UserTimeline from './components/UserTimeline.vue';
import twemoji from '@twemoji/api';

const app = createApp({});

app.component('tt-user-timeline', UserTimeline);

app.mount('#app');

twemoji.parse(document.body);

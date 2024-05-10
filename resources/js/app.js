import'./bootstrap';
import { createApp } from 'vue';
import UserTimeline from './components/UserTimeline.vue';
import emoji from './emoji';

const app = createApp({});

app.component('tt-user-timeline', UserTimeline);

app.mount('#app');

emoji(document.body);

import'./bootstrap';
import {App, createApp} from 'vue';
import UserTimeline from './components/UserTimeline.vue';
import emoji from './emoji';

const app: App<Element> = createApp({});

app.component('tt-user-timeline', UserTimeline);

app.mount('#app');

emoji(document.body);

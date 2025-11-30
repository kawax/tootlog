import './bootstrap';
import {App, createApp} from 'vue';
import UserTimeline from './components/UserTimeline.vue';
import {emoji} from './support/emoji';

const app: App<Element> = createApp({});

app.component('tt-user-timeline', UserTimeline);

if (document.getElementById('app')) {
    app.mount('#app');
}

emoji(document.body);

require("./bootstrap");

import { createApp } from 'vue';

const app = createApp({})


app.component("tt-user-timeline", require("./components/UserTimeline.vue").default);

const el = document.getElementById('app');

app.mount(el);

import twemoji from "twemoji";
twemoji.parse(document.body);

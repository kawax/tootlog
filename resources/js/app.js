/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

/**
 * Next, we will redirect a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("tt-user-timeline", require("./components/UserTimeline.vue").default);
Vue.component("tt-timeline-status", require("./components/TimelineStatus.vue").default);
Vue.component("tt-timeline-reblog", require("./components/TimelineReblog.vue").default);

Vue.component("tt-card", require("./components/Card.vue").default);

const app = new Vue({
  el: "#app"
});

$(window).resize(function() {
  app.$emit("redrawChart");
});

import twemoji from "twemoji";
twemoji.parse(document.body);

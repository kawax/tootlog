
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueCharts from 'vue-charts'
Vue.use(VueCharts)


/**
 * Next, we will redirect a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tt-status-toggle', require('./components/StatusToggle.vue'));

Vue.component('tt-user-timeline', require('./components/UserTimeline.vue'));
Vue.component('tt-timeline-status', require('./components/TimelineStatus.vue'));
Vue.component('tt-timeline-reblog', require('./components/TimelineReblog.vue'));
Vue.component('tt-calendar', require('./components/Calendar.vue'));

Vue.component('tt-card', require('./components/Card.vue'));

const app = new Vue({
    el: '#app'
});

$(window).resize(function () {
    app.$emit('redrawChart');
});

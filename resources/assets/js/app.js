
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

Vue.component('scrum', require('./components/Scrum.vue'));
Vue.component('scrum-voter', require('./components/ScrumVoter.vue'));
Vue.component('scrum-voters', require('./components/ScrumVoters.vue'));
Vue.component('vote-button', require('./components/VoteButton.vue'));
Vue.component('vote-buttons', require('./components/VoteButtons.vue'));
Vue.component('round-results', require('./components/RoundResults.vue'));
Vue.component('scrum-controls', require('./components/ScrumControls.vue'));

const app = new Vue({
    el: '#app'
});
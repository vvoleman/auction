import Vue from 'vue';
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
require('./bootstrap');

Vue.component('search-page', require('./components/search-page.vue').default);
Vue.component('slider', VueSlider)
const app = new Vue({
    el: '#app'
});

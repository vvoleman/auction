import Vue from 'vue';
import Snotify, { SnotifyPosition } from 'vue-snotify'; // 1. Import Snotify
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
import 'vue-snotify/styles/material.css';
require('./bootstrap');

const options = {
    toast: {
        position: SnotifyPosition.rightBottom,
        pauseOnHover:false,
        showProgressBar: false,
    }
}


Vue.use(Snotify,options);

Vue.component('search-page', require('./components/search-page.vue').default);
Vue.component('slider', VueSlider);
Vue.component('modal', require("./components/modal.vue").default);
Vue.component('config-categories',require('./components/config-categories').default);
const app = new Vue({
    el: '#app'
});

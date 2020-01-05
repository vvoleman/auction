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

Vue.component('search-page', require('./components/pages/search/search-page.vue').default);
Vue.component('config-categories',require('./components/pages/categories/config-categories').default);
Vue.component('config-groups',require('./components/pages/groups/config-groups.vue').default);
Vue.component('config-users',require('./components/pages/users/config-users.vue').default);
Vue.component('show-myoffers',require('./components/pages/myoffers/show-myoffers.vue').default);
Vue.component('show-selloffer',require('./components/pages/offers/show-selloffer.vue').default);

Vue.component('notifications',require('./components/sub/Notifications').default);
Vue.component('modal', require("./components/sub/modal.vue").default);
Vue.component('slider', VueSlider);
const app = new Vue({
    el: '#app'
});

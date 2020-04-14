import Vue from 'vue';
import VTooltip from 'v-tooltip';
import vSelect from 'vue-select';
import Snotify, { SnotifyPosition } from 'vue-snotify'; // 1. Import Snotify
import Vuesax from 'vuesax'

import 'vuesax/dist/vuesax.css' //Vuesax styles
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/default.css'
import 'vue-snotify/styles/material.css';
import 'vue-select/dist/vue-select.css';
require('./bootstrap');

const options = {
    toast: {
        position: SnotifyPosition.rightBottom,
        pauseOnHover:false,
        showProgressBar: false,
    }
}

Vue.use(Vuesax);
Vue.use(Snotify,options);
Vue.use(VTooltip);

Vue.component('v-select', vSelect);

Vue.component('search-page', require('./components/pages/search/search-page.vue').default);
Vue.component('config-categories',require('./components/pages/categories/config-categories').default);
Vue.component('config-groups',require('./components/pages/groups/config-groups.vue').default);
Vue.component('config-users',require('./components/pages/users/config-users.vue').default);
Vue.component('show-myoffers',require('./components/pages/myoffers/show-myoffers.vue').default);
Vue.component('show-myorders',require('./components/pages/myorders/show-myorders.vue').default);
Vue.component('show-selloffer',require('./components/pages/offers/show-selloffer.vue').default);
Vue.component('add-offer',require('./components/pages/newoffers/add-offer').default);
Vue.component('edit-offer',require('./components/pages/editoffers/editoffers').default);
Vue.component('edit-images',require('./components/pages/editoffers/edit-images').default);
Vue.component('confirm-offer-list',require('./components/pages/confirmoffers/confirm-offer-list').default);
Vue.component('messenger',require('./components/pages/messages/messenger.vue').default);
Vue.component('show-offersell',require('./components/pages/offersells/show-offersell').default);

Vue.component('admin-dashboard',require('./components/pages/adminpanel/Dashboard').default);

Vue.component('searchbar',require('./components/sub/searchbar').default);
Vue.component('gallery',require('./components/pages/newoffers/gallery').default);
Vue.component('offerlist',require('./components/pages/profile/offer_list').default);
Vue.component('notifications',require('./components/sub/Notifications').default);
Vue.component('message-indicator',require('./components/sub/MessageIndicator').default);
Vue.component('modal', require("./components/sub/modal.vue").default);
Vue.component('slider', VueSlider);
const app = new Vue({
    el: '#app'
});

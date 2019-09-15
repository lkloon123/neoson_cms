window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.moment = require('moment');
window.axios = require('axios');
import 'bootstrap';
import 'jquery.nicescroll';
import './stisla/stisla';
import Vue from 'vue';
import router from './routes';
import store from './store';
import AppInit from './pages/AppInit';
import VeeValidate from 'vee-validate';
import Utils from './plugins/utils';
import Toast from './plugins/toast';
import FileManager from 'laravel-file-manager';
import Rbac from './plugins/rbac';
import VueLazyLoad from 'vue-lazyload';
import FormatSizeFilter from './filters/format_size';

window.Vue = Vue;

Vue.use(VeeValidate, {events: ''});
Vue.use(Toast);
Vue.use(Utils);
Vue.use(Rbac);
Vue.use(FileManager, {store});
Vue.use(VueLazyLoad);

Vue.filter('formatSize', FormatSizeFilter);

require('./config/interceptors');
require('./config/router');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        AppInit
    }
});

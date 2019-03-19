require('./bootstrap');
import Vue from 'vue';
import router from './routes';
import store from './store';
import AppInit from './pages/AppInit';
import VeeValidate from 'vee-validate';
import Utils from './plugins/utils';
import Toast from './plugins/toast';

window.Vue = Vue;

Vue.use(VeeValidate, {events: ''});
Vue.use(Toast);
Vue.use(Utils);

require('./config/interceptors');
require('./config/router');

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        AppInit
    }
});

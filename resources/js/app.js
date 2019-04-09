require('./bootstrap');
import Vue from 'vue';
import router from './routes';
import store from './store';
import AppInit from './pages/AppInit';
import VeeValidate from 'vee-validate';
import Utils from './plugins/utils';
import Toast from './plugins/toast';
import FileManager from 'laravel-file-manager';
import Rbac from './plugins/rbac';

window.Vue = Vue;

Vue.use(VeeValidate, {events: ''});
Vue.use(Toast);
Vue.use(Utils);
Vue.use(Rbac);
Vue.use(FileManager, {store});

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

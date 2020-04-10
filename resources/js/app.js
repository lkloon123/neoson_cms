import 'bootstrap';
import 'jquery.nicescroll';
import './stisla/stisla';
import Vue from 'vue';
import VeeValidate from 'vee-validate';
import FileManager from 'laravel-file-manager';
import VueLazyLoad from 'vue-lazyload';
import axios from 'axios';
import VueCookies from 'vue-cookies';
import router from './routes';
import store from './store';
import AppInit from './pages/AppInit';
import Utils from './plugins/utils';
import Toast from './plugins/toast';
import Rbac from './plugins/rbac';
import FormatSizeFilter from './filters/format_size';
import i18n from './i18n';

Vue.use(VeeValidate, { events: '' });
Vue.use(Toast);
Vue.use(Utils);
Vue.use(Rbac);
Vue.use(FileManager, { store });
Vue.use(VueLazyLoad);
Vue.use(VueCookies);

Vue.filter('formatSize', FormatSizeFilter);

require('./config/interceptors');
require('./config/router');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// eslint-disable-next-line no-new
new Vue({
  el: '#app',
  i18n,
  router,
  store,
  components: {
    AppInit,
  },
});

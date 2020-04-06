import Vue from 'vue';
import Vuex from 'vuex';

import * as actions from './store/actions';
import * as getters from './store/getters';
import * as mutations from './store/mutations';

import modules from './store/modules/index';

Vue.use(Vuex);

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',

  modules,
  state: {
    currentPageTitle: '',
    pageBackLink: null,
    currentUserInfo: null,
    currentUserRole: null,
    currentUserPermission: [],
    showLoader: false,
    locale: null,
  },
  getters,
  mutations,
  actions,
});

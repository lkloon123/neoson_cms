import Vue from 'vue';
import Vuex from 'vuex';

import state from './store/state';
import actions from './store/actions';
import getters from './store/getters';
import mutations from './store/mutations';

import modules from './store/modules/index';

Vue.use(Vuex);

export default new Vuex.Store({
  strict: process.env.NODE_ENV !== 'production',
  modules,
  state,
  getters,
  mutations,
  actions,
});

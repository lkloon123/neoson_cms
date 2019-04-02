import Vue from 'vue';
import Vuex from 'vuex';

import * as actions from './store/actions';
import * as getters from './store/getters';
import * as mutations from './store/mutations';

import menu from './store/modules/menu';
import form from './store/modules/form';

Vue.use(Vuex);

export default new Vuex.Store({
    strict: process.env.NODE_ENV !== 'production',

    modules: {
        menu,
        form
    },
    state: {
        currentPageTitle: '',
        pageBackLink: null,
        currentUserInfo: null,
    },
    getters,
    mutations,
    actions
});

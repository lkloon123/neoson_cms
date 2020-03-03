/* eslint no-shadow: ["error", { "allow": ["state"] }] */
import Vue from 'vue';
import { cloneDeep } from 'lodash';

const initialState = () => ({
  selectedIndex: null,
  formItems: [],
  formComponents: [],
  coreLoading: true,
});

const state = initialState();

const getters = {
  getHtmlElementByType: (state) => (formType) => state.formComponents.find((formComponent) => formComponent.default_meta.type === formType)?.html_component,
};

const mutations = {
  SET_FORM_ITEMS: (state, payload) => { state.formItems = payload; },
  SET_SELECTED_FORM_ITEM_INDEX: (state, payload) => { state.selectedIndex = payload; },
  ADD_FORM_ITEM: (state, payload) => {
    const cloned = cloneDeep(payload);
    cloned.id = Vue.prototype.$Utils.getRandomId();
    state.formItems.push(cloned);
  },
  UPDATE_FORM_ITEM: (state, payload) => {
    if (state.selectedIndex === null) {
      return;
    }
    Vue.prototype.$set(state.formItems, state.selectedIndex, payload);
  },
  REMOVE_FORM_ITEM: (state) => {
    if (state.selectedIndex === null) {
      return;
    }
    Vue.prototype.$delete(state.formItems, state.selectedIndex);
  },
  SET_FORM_COMPONENTS: (state, payload) => { state.formComponents = payload; },
  UPDATE_CORE_LOADING: (state, payload) => { state.coreLoading = payload; },
  RESET_STATE: (state) => Object.assign(state, initialState()),
};

const actions = {};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions,
};

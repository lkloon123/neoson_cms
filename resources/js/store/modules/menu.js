/* eslint no-shadow: ["error", { "allow": ["state"] }] */
import Vue from 'vue';
import { cloneDeep } from 'lodash';

const initialState = () => ({
  menuItems: [],
  coreLoading: true,
});

const state = initialState();

const getters = {};

const mutations = {
  SET_MENU_ITEMS: (state, payload) => { state.menuItems = payload; },
  ADD_MENU_ITEM: (state, payload) => {
    const tmp = {
      id: Vue.prototype.$Utils.getRandomId(),
      showMenuOption: false,
      children: [],
    };

    const cloned = cloneDeep(payload);
    Object.assign(tmp, cloned);
    state.menuItems.push(tmp);
  },
  UPDATE_MENU_ITEM: (state, payload) => {
    const clonePayload = cloneDeep(payload);
    delete clonePayload.children;

    const found = Vue.prototype.$Utils.findId(state.menuItems, clonePayload.id);
    Object.assign(found.current, clonePayload);
  },
  UPDATE_MENU_ITEM_KEY: (state, { id, key, value }) => {
    const found = Vue.prototype.$Utils.findId(state.menuItems, id);

    const clonedItem = cloneDeep(found.current);
    delete clonedItem.children;
    clonedItem[key] = value;

    Object.assign(found.current, clonedItem);
  },
  REMOVE_MENU_ITEM: (state, payload) => {
    const found = Vue.prototype.$Utils.findId(state.menuItems, payload.id);
    let foundIndex = null;

    found.parent.forEach((o, index) => {
      if (o.id === payload.id) {
        foundIndex = index;
      }
    });

    // remove the object
    found.parent.splice(foundIndex, 1);

    // move all children up 1 level
    if (payload.children && payload.children.length > 0) {
      if (payload.children.length > 1) {
        for (let pullMenuIndex = 1; pullMenuIndex < payload.children.length; pullMenuIndex += 1) {
          payload.children[0].children.push(payload.children[pullMenuIndex]);
        }
      }
      found.parent.splice(foundIndex, 0, payload.children[0]);
    }
  },
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

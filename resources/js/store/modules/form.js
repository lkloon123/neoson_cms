import Vue from 'vue';

const initialState = () => ({
    selectedIndex: null,
    formItems: [],
    coreLoading: true
});

const state = initialState();

const getters = {};

const mutations = {
    SET_FORM_ITEMS: (state, payload) => state.formItems = payload,
    SET_SELECTED_FORM_ITEM_INDEX: (state, payload) => state.selectedIndex = payload,
    ADD_FORM_ITEM: (state, payload) => {
        const cloned = Object.assign({}, payload);
        cloned.id = Vue.prototype.$Utils.getRandomId();
        state.formItems.push(cloned);
    },
    UPDATE_FORM_ITEM: (state, payload) => {
        if (state.selectedIndex === null) {
            return false;
        }
        Vue.prototype.$set(state.formItems, state.selectedIndex, payload);
    },
    REMOVE_FORM_ITEM: (state, payload) => {
        if (state.selectedIndex === null) {
            return false;
        }
        Vue.prototype.$delete(state.formItems, state.selectedIndex);
    },
    UPDATE_CORE_LOADING: (state, payload) => state.coreLoading = payload,
    RESET_STATE: (state) => Object.assign(state, initialState()),
};

const actions = {};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}

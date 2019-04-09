import router from '../routes';
import store from '../store';
import Vue from 'vue';

router.beforeEach(async (to, from, next) => {
    store.commit('SET_PAGE_BACK_LINK', null);

    let hasPermission = async () => {
        if (store.state.currentUserRole === null) {
            await store.dispatch('getRbac');
        }
        if (to.meta.module && to.meta.permission) {
            return Vue.prototype.$rbac.can(to.meta.permission, to.meta.module);
        }
        return true;
    };

    if (await hasPermission()) {
        next();
    } else {
        next('unauthorized')
    }
});

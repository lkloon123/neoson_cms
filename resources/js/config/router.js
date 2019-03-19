import router from '../routes';
import store from '../store';

router.beforeEach((to, from, next) => {
    store.commit('SET_PAGE_BACK_LINK', null);
    next();
});

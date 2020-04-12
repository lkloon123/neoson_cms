import router from '../routes';
import store from '../store';

const checkPermission = async (meta) => {
  // dispatch if not role not loaded
  if (store.state.currentUserRole === null) {
    await store.dispatch('getRbac');
  }

  if (meta?.module && meta?.permission) {
    return store.getters.hasPermission(meta.permission, meta.module);
  }

  return true;
};

router.beforeEach(async (to, from, next) => {
  store.commit('UPDATE_LOADER', true);
  store.commit('SET_PAGE_BACK_LINK', null);

  if (store.state.locale === null) {
    await store.dispatch('loadAppLocale');
  }

  if (await checkPermission(to.meta)) {
    next();
  } else {
    next('unauthorized');
  }
});

router.afterEach(() => {
  setTimeout(() => {
    store.commit('UPDATE_LOADER', false);
  }, 500);
});

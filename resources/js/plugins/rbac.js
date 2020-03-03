import store from '../store';

export default function (Vue) {
  Vue.rbac = {
    can(permission, module) {
      return this.is('superadmin') || !!(store.state.currentUserPermission.find((o) => o.name === permission && o.module === module));
    },
    is(role) {
      return store.state.currentUserRole === role;
    },
  };

  Object.defineProperties(Vue.prototype, {
    $rbac: {
      get() {
        return Vue.rbac;
      },
    },
  });
}

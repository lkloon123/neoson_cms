const hasPermission = (state, getters) => (permission, module) => getters.isA('superadmin') || !!(state.currentUserPermission.find((o) => o.name === permission && o.module === module));
const isA = (state) => (role) => state.currentUserRole === role;

export default {
  hasPermission,
  isA,
};

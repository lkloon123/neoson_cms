export default {
  methods: {
    hasPermission(permission, module) {
      return this.$rbac.can(permission, module);
    },
  },
};

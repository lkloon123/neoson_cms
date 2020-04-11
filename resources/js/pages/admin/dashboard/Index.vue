<template>
  <div class="row mb-4">
    <div
      v-if="hasPermission('view', 'page')"
      class="col-lg-3 col-md-6 col-sm-6 col-12"
    >
      <total-pages />
    </div>
    <div
      v-if="hasPermission('view', 'post')"
      class="col-lg-3 col-md-6 col-sm-6 col-12"
    >
      <total-posts />
    </div>
    <div
      v-if="hasPermission('view', 'user_manage')"
      class="col-lg-3 col-md-6 col-sm-6 col-12"
    >
      <total-users />
    </div>
  </div>
</template>

<script>
import PermissionMixin from '@mixins/permission_mixin';
import TotalPages from './components/TotalPages';
import TotalPosts from './components/TotalPosts';
import TotalUsers from './components/TotalUsers';

export default {
  components: {
    TotalPages, TotalPosts, TotalUsers,
  },
  mixins: [PermissionMixin],
  created() {
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.dashboard');
  },
};
</script>

<template>
  <div class="row">
    <div
      v-if="hasPermission('view', 'general_setting')"
      class="col-md-6 col-sm-12"
    >
      <div class="card card-large-icons">
        <div class="card-icon bg-primary text-white">
          <i class="fas fa-cog" />
        </div>
        <div class="card-body">
          <h4>General</h4>
          <p>General settings such as site title, description</p>
          <router-link
            class="card-cta"
            to="/settings/general"
          >
            {{ btnSettingText('general') }}
          </router-link>
        </div>
      </div>
    </div>
    <div
      v-if="hasPermission('view', 'integration_setting')"
      class="col-md-6 col-sm-12"
    >
      <div class="card card-large-icons">
        <div class="card-icon bg-primary text-white">
          <i class="fas fa-link" />
        </div>
        <div class="card-body">
          <h4>Integration</h4>
          <p>Integration settings with other services</p>
          <router-link
            class="card-cta"
            to="/settings/integration"
          >
            {{ btnSettingText('integration') }}
          </router-link>
        </div>
      </div>
    </div>
    <div
      v-if="hasPermission('view', 'acl_setting')"
      class="col-md-6 col-sm-12"
    >
      <div class="card card-large-icons">
        <div class="card-icon bg-primary text-white">
          <i class="fas fa-user-lock" />
        </div>
        <div class="card-body">
          <h4>Roles And Permission</h4>
          <p>Roles and permission setting</p>
          <router-link
            class="card-cta"
            to="/settings/roles"
          >
            {{ btnSettingText('acl') }}
          </router-link>
        </div>
      </div>
    </div>
    <div
      v-if="hasPermission('view', 'user_manage')"
      class="col-md-6 col-sm-12"
    >
      <div class="card card-large-icons">
        <div class="card-icon bg-primary text-white">
          <i class="fas fa-user" />
        </div>
        <div class="card-body">
          <h4>User Management</h4>
          <p>Manage user setting</p>
          <router-link
            class="card-cta"
            to="/settings/users"
          >
            Change Setting
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PermissionMixin from '@mixins/permission_mixin';

export default {
  mixins: [PermissionMixin],
  created() {
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'Settings');
  },
  methods: {
    btnSettingText(group) {
      if (this.hasPermission('update', `${group}_setting`)) {
        return 'Change Setting';
      }

      return 'View Setting';
    },
  },
};
</script>

<style scoped>

</style>

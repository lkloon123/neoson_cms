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
          <h4>{{ $t('setting.general') }}</h4>
          <p>{{ $t('setting.general_description_text') }}</p>
          <router-link
            class="card-cta"
            to="/settings/general"
          >
            {{ $t(btnSettingText('general')) }}
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
          <h4>{{ $t('setting.integration') }}</h4>
          <p>{{ $t('setting.integration_description_text') }}</p>
          <router-link
            class="card-cta"
            to="/settings/integration"
          >
            {{ $t(btnSettingText('integration')) }}
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
          <h4>{{ $t('setting.roles_and_permission') }}</h4>
          <p>{{ $t('setting.roles_and_permission_description_text') }}</p>
          <router-link
            class="card-cta"
            to="/settings/roles"
          >
            {{ $t(btnSettingText('acl')) }}
          </router-link>
        </div>
      </div>
    </div>
    <div
      v-if="hasPermission('update', 'translation')"
      class="col-md-6 col-sm-12"
    >
      <div class="card card-large-icons">
        <div class="card-icon bg-primary text-white">
          <i class="fas fa-globe" />
        </div>
        <div class="card-body">
          <h4>{{ $t('setting.translation') }}</h4>
          <p>{{ $t('setting.translation_description_text') }}</p>
          <router-link
            class="card-cta"
            to="/settings/translations"
          >
            {{ $t('setting.change_setting') }}
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
          <h4>{{ $t('setting.user_management') }}</h4>
          <p>{{ $t('setting.user_management_description_text') }}</p>
          <router-link
            class="card-cta"
            to="/settings/users"
          >
            {{ $t('setting.change_setting') }}
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
    this.$store.commit('SET_CURRENT_PAGE_TITLE', 'menu.settings');
  },
  methods: {
    btnSettingText(group) {
      if (this.hasPermission('update', `${group}_setting`)) {
        return 'setting.change_setting';
      }

      return 'setting.view_setting';
    },
  },
};
</script>

<style scoped>

</style>

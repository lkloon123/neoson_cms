<template>
  <div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <router-link to="/dashboard">
          NeoSon<strong>CMS</strong>
        </router-link>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <router-link to="/dashboard">
          NEO
        </router-link>
      </div>

      <ul class="sidebar-menu">
        <router-link
          to="/dashboard"
          tag="li"
        >
          <a><i class="fas fa-fire" /><span>{{ $t('menu.dashboard') }}</span></a>
        </router-link>
        <router-link
          v-if="hasPermission('view', 'page')"
          to="/pages"
          tag="li"
        >
          <a><i class="fas fa-file" /><span>{{ $t('menu.pages') }}</span></a>
        </router-link>
        <li
          v-if="hasPermission('view', 'post')"
          class="dropdown"
          :class="{active: subIsActive('/post') || subIsActive('/tags')}"
        >
          <a
            href="#"
            class="nav-link has-dropdown"
            data-toggle="dropdown"
          >
            <i class="fas fa-highlighter" /> <span>{{ $t('menu.blogging') }}</span>
          </a>
          <ul class="dropdown-menu">
            <router-link
              v-if="hasPermission('view', 'post')"
              to="/posts"
              tag="li"
            >
              <a><i class="fas fa-align-left" /> <span>{{ $t('menu.posts') }}</span></a>
            </router-link>
            <router-link
              v-if="hasPermission('view', 'post')"
              to="/tags"
              tag="li"
            >
              <a><i class="fas fa-tags" /> <span>{{ $t('menu.tags') }}</span></a>
            </router-link>
          </ul>
        </li>
        <router-link
          v-if="hasPermission('view', 'form')"
          to="/forms"
          tag="li"
        >
          <a><i class="fas fa-file-signature" /><span>{{ $t('menu.forms') }}</span></a>
        </router-link>
        <router-link
          to="/file-manager"
          tag="li"
        >
          <a><i class="fas fa-folder-open" /><span>{{ $t('menu.file_manager') }}</span></a>
        </router-link>
        <li
          v-if="hasPermission('view', 'menu')"
          class="dropdown"
          :class="{active: subIsActive('/menu')}"
        >
          <a
            href="#"
            class="nav-link has-dropdown"
            data-toggle="dropdown"
          >
            <i class="fas fa-paint-brush" /> <span>{{ $t('menu.appearance') }}</span>
          </a>
          <ul class="dropdown-menu">
            <router-link
              v-if="hasPermission('view', 'menu')"
              to="/menu"
              tag="li"
            >
              <a><i class="fas fa-compass" /> <span>{{ $t('menu.menu') }}</span></a>
            </router-link>
          </ul>
        </li>
        <router-link
          v-if="hasPermission('view', 'plugin')"
          to="/plugins"
          tag="li"
        >
          <a><i class="fas fa-plug" /> <span>{{ $t('menu.plugins') }}</span></a>
        </router-link>
        <router-link
          v-if="hasPermission('view', 'general_setting') || hasPermission('view', 'acl_setting') || hasPermission('view', 'user_manage')"
          tag="li"
          to="/settings"
        >
          <a><i class="fas fa-cogs" /><span>{{ $t('menu.settings') }}</span></a>
        </router-link>
      </ul>
    </aside>
  </div>
</template>

<script>
import PermissionMixin from '@mixins/permission_mixin.js';

export default {
  mixins: [PermissionMixin],
  methods: {
    subIsActive(input) {
      const paths = Array.isArray(input) ? input : [input];
      return paths.some((path) => this.$route.path.indexOf(path) === 0);
    },
  },
};
</script>

<style scoped>

</style>

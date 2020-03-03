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
          <a><i class="fas fa-fire" /><span>Dashboard</span></a>
        </router-link>
        <router-link
          v-if="hasPermission('view', 'page')"
          to="/pages"
          tag="li"
        >
          <a><i class="fas fa-file" /><span>Pages</span></a>
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
            <i class="fas fa-highlighter" /> <span>Blogging</span>
          </a>
          <ul class="dropdown-menu">
            <router-link
              v-if="hasPermission('view', 'post')"
              to="/posts"
              tag="li"
            >
              <a><i class="fas fa-align-left" /> <span>Posts</span></a>
            </router-link>
            <router-link
              v-if="hasPermission('view', 'post')"
              to="/tags"
              tag="li"
            >
              <a><i class="fas fa-tags" /> <span>Tags</span></a>
            </router-link>
          </ul>
        </li>
        <router-link
          v-if="hasPermission('view', 'form')"
          to="/forms"
          tag="li"
        >
          <a><i class="fas fa-file-signature" /><span>Forms</span></a>
        </router-link>
        <router-link
          to="/file-manager"
          tag="li"
        >
          <a><i class="fas fa-folder-open" /><span>File Manager</span></a>
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
            <i class="fas fa-paint-brush" /> <span>Appearance</span>
          </a>
          <ul class="dropdown-menu">
            <router-link
              v-if="hasPermission('view', 'menu')"
              to="/menu"
              tag="li"
            >
              <a><i class="fas fa-compass" /> <span>Menu</span></a>
            </router-link>
          </ul>
        </li>
        <router-link
          to="/plugins"
          tag="li"
        >
          <a><i class="fas fa-plug" /> <span>Plugins</span></a>
        </router-link>
        <router-link
          v-if="hasPermission('view', 'general_setting') || hasPermission('view', 'acl_setting')"
          tag="li"
          to="/settings"
        >
          <a><i class="fas fa-cogs" /><span>Settings</span></a>
        </router-link>
      </ul>
    </aside>
  </div>
</template>

<script>
export default {
  methods: {
    subIsActive(input) {
      const paths = Array.isArray(input) ? input : [input];
      return paths.some((path) => this.$route.path.indexOf(path) === 0);
    },
    hasPermission(permission, module) {
      return this.$rbac.can(permission, module);
    },
  },
};
</script>

<style scoped>

</style>

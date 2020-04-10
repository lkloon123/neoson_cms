import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: () => import('./pages/admin/layout/Main.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '/',
        redirect: 'dashboard',
      },
      {
        path: 'dashboard',
        component: () => import('./pages/admin/dashboard/Index.vue'),
        name: 'dashboard',
        meta: {
          breadcrumb: [
            { name: 'menu.dashboard' },
          ],
        },
      },
      {
        path: 'file-manager',
        component: () => import('./pages/admin/file_manager/Index.vue'),
        meta: {
          breadcrumb: [
            { name: 'menu.dashboard', link: '/dashboard' },
            { name: 'menu.file_manager' },
          ],
        },
      },
      {
        path: 'forms',
        component: () => import('./pages/admin/form/Index.vue'),
        children: [
          {
            path: '/',
            component: () => import('./pages/admin/form/ShowAll.vue'),
            name: 'form.showall',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.forms' },
              ],
              module: 'form',
              permission: 'view',
            },
          },
          {
            path: 'create',
            component: () => import('./pages/admin/form/CreateAndEdit.vue'),
            name: 'form.create',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.forms', link: '/forms' },
                { name: 'form.create_form' },
              ],
              module: 'form',
              permission: 'create',
            },
          },
          {
            path: 'edit/:id',
            component: () => import('./pages/admin/form/CreateAndEdit.vue'),
            props: { mode: 'edit' },
            name: 'form.edit',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.forms', link: '/forms' },
                { name: 'form.edit_form' },
              ],
              module: 'form',
              permission: 'update',
            },
          },
          {
            path: 'responses/:id',
            component: () => import('./pages/admin/form/Responses.vue'),
            name: 'form.responses',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.forms', link: '/forms' },
                { name: 'form.form_responses' },
              ],
              module: 'form',
              permission: 'view',
            },
          },
        ],
      },
      {
        path: 'pages',
        component: () => import('./pages/admin/page/Index.vue'),
        children: [
          {
            path: '/',
            component: () => import('./pages/admin/page/ShowAll.vue'),
            name: 'page.showall',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.pages' },
              ],
              module: 'page',
              permission: 'view',
            },
          },
          {
            path: 'create',
            component: () => import('./pages/admin/page/CreateAndEdit.vue'),
            name: 'page.create',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.pages', link: '/pages' },
                { name: 'page.create_page' },
              ],
              module: 'page',
              permission: 'create',
            },
          },
          {
            path: 'edit/:id',
            component: () => import('./pages/admin/page/CreateAndEdit.vue'),
            props: { mode: 'edit' },
            name: 'page.edit',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.pages', link: '/pages' },
                { name: 'page.edit_page' },
              ],
              module: 'page',
              permission: 'update',
            },
          },
        ],
      },
      {
        path: 'posts',
        component: () => import('./pages/admin/post/Index.vue'),
        children: [
          {
            path: '/',
            component: () => import('./pages/admin/post/ShowAll.vue'),
            name: 'post.showall',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.posts' },
              ],
              module: 'post',
              permission: 'view',
            },
          },
          {
            path: 'create',
            component: () => import('./pages/admin/post/CreateAndEdit.vue'),
            name: 'post.create',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.posts', link: '/posts' },
                { name: 'post.create_post' },
              ],
              module: 'post',
              permission: 'create',
            },
          },
          {
            path: 'edit/:id',
            component: () => import('./pages/admin/post/CreateAndEdit.vue'),
            props: { mode: 'edit' },
            name: 'post.edit',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.posts', link: '/posts' },
                { name: 'post.edit_post' },
              ],
              module: 'post',
              permission: 'update',
            },
          },
        ],
      },
      {
        path: 'tags',
        component: () => import('./pages/admin/tag/Index.vue'),
        children: [
          {
            path: '/',
            component: () => import('./pages/admin/tag/ShowAll.vue'),
            name: 'tag.showall',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.tags' },
              ],
              module: 'post',
              permission: 'view',
            },
          },
        ],
      },
      {
        path: 'menu',
        component: () => import('./pages/admin/menu/Index.vue'),
        children: [
          {
            path: '/',
            component: () => import('./pages/admin/menu/ShowAll.vue'),
            name: 'menu.showall',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.menu' },
              ],
              module: 'menu',
              permission: 'view',
            },
          },
          {
            path: 'create',
            component: () => import('./pages/admin/menu/CreateAndEdit.vue'),
            name: 'menu.create',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.menu', link: '/menu' },
                { name: 'menu.create_menu' },
              ],
              module: 'menu',
              permission: 'create',
            },
          },
          {
            path: 'edit/:id',
            component: () => import('./pages/admin/menu/CreateAndEdit.vue'),
            props: { mode: 'edit' },
            name: 'menu.edit',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.menu', link: '/menu' },
                { name: 'menu.edit_menu' },
              ],
              module: 'menu',
              permission: 'update',
            },
          },
        ],
      },
      {
        path: 'plugins',
        component: () => import('./pages/admin/plugin/Index.vue'),
        children: [
          {
            path: '/',
            component: () => import('./pages/admin/plugin/ShowAll.vue'),
            name: 'plugin.showall',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.plugins' },
              ],
              module: 'plugin',
              permission: 'view',
            },
          },
          {
            path: 'installer',
            component: () => import('./pages/admin/plugin/Installer.vue'),
            name: 'plugin.installer',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.plugins', link: '/plugins' },
                { name: 'plugin.install_plugin' },
              ],
              module: 'plugin',
              permission: 'create',
            },
          },
        ],
      },
      {
        path: 'settings',
        component: () => import('./pages/admin/setting/Index.vue'),
        children: [
          {
            path: '/',
            component: () => import('./pages/admin/setting/ShowAll.vue'),
            name: 'setting.showall',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.settings' },
              ],
            },
          },
          {
            path: 'general',
            component: () => import('./pages/admin/setting/General.vue'),
            name: 'setting.general',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.settings', link: '/settings' },
                { name: 'setting.general_settings' },
              ],
              module: 'general_setting',
              permission: 'view',
            },
          },
          {
            path: 'integration',
            component: () => import('./pages/admin/setting/Integration.vue'),
            name: 'setting.integration',
            meta: {
              breadcrumb: [
                { name: 'menu.dashboard', link: '/dashboard' },
                { name: 'menu.settings', link: '/settings' },
                { name: 'setting.integration_settings' },
              ],
              module: 'integration_setting',
              permission: 'view',
            },
          },
          {
            path: 'roles',
            component: () => import('./pages/admin/role/Index.vue'),
            children: [
              {
                path: '/',
                component: () => import('./pages/admin/role/ShowAll.vue'),
                name: 'setting.role.showall',
                meta: {
                  breadcrumb: [
                    { name: 'menu.dashboard', link: '/dashboard' },
                    { name: 'menu.settings', link: '/settings' },
                    { name: 'setting.roles_and_permission' },
                  ],
                  module: 'acl_setting',
                  permission: 'view',
                },
              },
              {
                path: 'create',
                component: () => import('./pages/admin/role/CreateAndEdit.vue'),
                name: 'setting.role.create',
                meta: {
                  breadcrumb: [
                    { name: 'menu.dashboard', link: '/dashboard' },
                    { name: 'menu.settings', link: '/settings' },
                    { name: 'setting.roles_and_permission', link: '/settings/roles' },
                    { name: 'role.create_role' },
                  ],
                  module: 'acl_setting',
                  permission: 'create',
                },
              },
              {
                path: 'edit/:id',
                component: () => import('./pages/admin/role/CreateAndEdit.vue'),
                props: { mode: 'edit' },
                name: 'setting.role.edit',
                meta: {
                  breadcrumb: [
                    { name: 'menu.dashboard', link: '/dashboard' },
                    { name: 'menu.settings', link: '/settings' },
                    { name: 'setting.roles_and_permission', link: '/settings/roles' },
                    { name: 'role.edit_role' },
                  ],
                  module: 'acl_setting',
                  permission: 'update',
                },
              },
            ],
          },
          {
            path: 'users',
            component: () => import('./pages/admin/user/Index.vue'),
            children: [
              {
                path: '/',
                component: () => import('./pages/admin/user/ShowAll.vue'),
                name: 'setting.user.showall',
                meta: {
                  breadcrumb: [
                    { name: 'menu.dashboard', link: '/dashboard' },
                    { name: 'menu.settings', link: '/settings' },
                    { name: 'setting.users' },
                  ],
                  module: 'user_manage',
                  permission: 'view',
                },
              },
              {
                path: 'create',
                component: () => import('./pages/admin/user/CreateAndEdit.vue'),
                name: 'setting.user.create',
                meta: {
                  breadcrumb: [
                    { name: 'menu.dashboard', link: '/dashboard' },
                    { name: 'menu.settings', link: '/settings' },
                    { name: 'setting.users', link: '/settings/users' },
                    { name: 'user.create_user' },
                  ],
                  module: 'user_manage',
                  permission: 'create',
                },
              },
            ],
          },
          {
            path: 'translations',
            component: () => import('./pages/admin/translation/Index.vue'),
            children: [
              {
                path: '/',
                component: () => import('./pages/admin/translation/ShowAll.vue'),
                meta: {
                  breadcrumb: [
                    { name: 'menu.dashboard', link: '/dashboard' },
                    { name: 'menu.settings', link: '/settings' },
                    { name: 'setting.translation' },
                  ],
                  module: 'translation',
                  permission: 'update',
                },
              },
              {
                path: 'edit/:id',
                component: () => import('./pages/admin/translation/CreateAndEdit.vue'),
                props: { mode: 'edit' },
                name: 'translation.edit',
                meta: {
                  breadcrumb: [
                    { name: 'menu.dashboard', link: '/dashboard' },
                    { name: 'menu.settings', link: '/settings' },
                    { name: 'setting.translation', link: '/settings/translations' },
                    { name: 'translation.edit_translation' },
                  ],
                  module: 'translation',
                  permission: 'update',
                },
              },
            ],
          },
        ],
      },
      {
        path: 'unauthorized',
        component: () => import('./pages/Unauthorized.vue'),
        name: 'error.unauthorized',
      },
      {
        path: '*',
        component: () => import('./pages/NotFound.vue'),
        name: 'error.notfound',
      },
    ],
  },
];

export default new VueRouter({
  routes,
  mode: 'history',
  base: '/admin/',
  linkActiveClass: 'active',
  scrollBehavior: (to, from, savedPosition) => savedPosition || { x: 0, y: 0 },
});

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
            { name: 'Dashboard' },
          ],
        },
      },
      {
        path: 'file-manager',
        component: () => import('./pages/admin/file_manager/Index.vue'),
        meta: {
          breadcrumb: [
            { name: 'Dashboard', link: '/dashboard' },
            { name: 'File Manager' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Forms' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Forms', link: '/forms' },
                { name: 'Create new form' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Forms', link: '/forms' },
                { name: 'Edit form' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Forms', link: '/forms' },
                { name: 'Form responses' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Pages' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Pages', link: '/pages' },
                { name: 'Create new page' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Pages', link: '/pages' },
                { name: 'Edit page' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Posts' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Posts', link: '/posts' },
                { name: 'Create new post' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Posts', link: '/posts' },
                { name: 'Edit post' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Tags' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Menu' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Menu', link: '/menu' },
                { name: 'Create new menu' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Menu', link: '/menu' },
                { name: 'Edit menu' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Plugins' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Plugins', link: '/plugins' },
                { name: 'Installer' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Settings' },
              ],
            },
          },
          {
            path: 'general',
            component: () => import('./pages/admin/setting/General.vue'),
            name: 'setting.general',
            meta: {
              breadcrumb: [
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Settings', link: '/settings' },
                { name: 'General' },
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
                { name: 'Dashboard', link: '/dashboard' },
                { name: 'Settings', link: '/settings' },
                { name: 'Integration' },
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
                    { name: 'Dashboard', link: '/dashboard' },
                    { name: 'Settings', link: '/settings' },
                    { name: 'Roles' },
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
                    { name: 'Dashboard', link: '/dashboard' },
                    { name: 'Settings', link: '/settings' },
                    { name: 'Roles', link: '/settings/roles' },
                    { name: 'Create new role' },
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
                    { name: 'Dashboard', link: '/dashboard' },
                    { name: 'Settings', link: '/settings' },
                    { name: 'Roles', link: '/settings/roles' },
                    { name: 'Edit role' },
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
                    { name: 'Dashboard', link: '/dashboard' },
                    { name: 'Settings', link: '/settings' },
                    { name: 'Users' },
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
                    { name: 'Dashboard', link: '/dashboard' },
                    { name: 'Settings', link: '/settings' },
                    { name: 'Users', link: '/settings/roles' },
                    { name: 'Create new user' },
                  ],
                  module: 'user_manage',
                  permission: 'create',
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

const router = new VueRouter({
  routes,
  mode: 'history',
  base: '/admin/',
  linkActiveClass: 'active',
  scrollBehavior: (to, from, savedPosition) => savedPosition || { x: 0, y: 0 },
});

export default router;

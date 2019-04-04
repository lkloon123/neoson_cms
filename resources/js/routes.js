import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: () => import('./pages/admin/layout/Main.vue'),
        meta: {requiresAuth: true},
        children: [
            {
                path: '/',
                redirect: 'dashboard'
            },
            {
                path: 'dashboard',
                component: () => import('./pages/admin/dashboard/Index.vue'),
                name: 'dashboard',
                meta: {
                    breadcrumb: [
                        {name: 'Dashboard'}
                    ]
                }
            },
            {
                path: 'file-manager',
                component: () => import('./pages/admin/file_manager/Index.vue'),
                meta: {
                    breadcrumb: [
                        {name: 'Dashboard', link: '/dashboard'},
                        {name: 'File Manager'}
                    ]
                }
            },
            {
                path: 'forms',
                component: () => import ('./pages/admin/form/Index.vue'),
                children: [
                    {
                        path: '/',
                        component: () => import('./pages/admin/form/ShowAll.vue'),
                        name: 'form.showall',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Forms'}
                            ]
                        }
                    },
                    {
                        path: 'create',
                        component: () => import('./pages/admin/form/CreateAndEdit.vue'),
                        name: 'form.create',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Forms', link: '/forms'},
                                {name: 'Create new form'}
                            ]
                        }
                    },
                    {
                        path: 'edit/:id',
                        component: () => import('./pages/admin/form/CreateAndEdit.vue'),
                        props: {mode: 'edit'},
                        name: 'form.edit',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Forms', link: '/forms'},
                                {name: 'Edit form'}
                            ]
                        }
                    },
                    {
                        path: 'responses/:id',
                        component: () => import('./pages/admin/form/Responses.vue'),
                        name: 'form.responses',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Forms', link: '/forms'},
                                {name: 'Form responses'}
                            ]
                        }
                    }
                ]
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
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Pages'}
                            ]
                        }
                    },
                    {
                        path: 'create',
                        component: () => import('./pages/admin/page/CreateAndEdit.vue'),
                        name: 'page.create',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Pages', link: '/pages'},
                                {name: 'Create new page'}
                            ]
                        }
                    },
                    {
                        path: 'edit/:id',
                        component: () => import('./pages/admin/page/CreateAndEdit.vue'),
                        props: {mode: 'edit'},
                        name: 'page.edit',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Pages', link: '/pages'},
                                {name: 'Edit page'}
                            ]
                        }
                    }
                ]
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
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Posts'}
                            ]
                        }
                    },
                    {
                        path: 'create',
                        component: () => import('./pages/admin/post/CreateAndEdit.vue'),
                        name: 'post.create',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Posts', link: '/posts'},
                                {name: 'Create new post'}
                            ]
                        }
                    },
                    {
                        path: 'edit/:id',
                        component: () => import('./pages/admin/post/CreateAndEdit.vue'),
                        props: {mode: 'edit'},
                        name: 'post.edit',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Posts', link: '/posts'},
                                {name: 'Edit post'}
                            ]
                        }
                    }
                ]
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
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Menu'}
                            ]
                        }
                    },
                    {
                        path: 'create',
                        component: () => import('./pages/admin/menu/CreateAndEdit.vue'),
                        name: 'menu.create',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Menu', link: '/menu'},
                                {name: 'Create new menu'}
                            ]
                        }
                    },
                    {
                        path: 'edit/:id',
                        component: () => import('./pages/admin/menu/CreateAndEdit.vue'),
                        props: {mode: 'edit'},
                        name: 'menu.edit',
                        meta: {
                            breadcrumb: [
                                {name: 'Dashboard', link: '/dashboard'},
                                {name: 'Menu', link: '/menu'},
                                {name: 'Edit menu'}
                            ]
                        }
                    }
                ]
            },
            {
                path: '*',
                component: () => import('./pages/NotFound.vue'),
                name: 'error.notfound'
            },
        ]
    }
];

const router = new VueRouter({
    routes: routes,
    mode: 'history',
    base: '/admin/',
    linkActiveClass: 'active',
    scrollBehavior: (to, from, savedPosition) => {
        return savedPosition || {x: 0, y: 0}
    }
});

export default router;

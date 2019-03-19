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

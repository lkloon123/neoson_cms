import VueRouter from 'vue-router';

const routes = [
    {
        path: '/admin',
        component: () => import('./pages/admin/layout/Main.vue'),
        meta: {requiresAuth: true},
        children: [
            {
                path: 'pages',
                component: () => import('./pages/page/Index.vue')
            },
            {
                path: '*',
                component: () => import('./pages/NotFound.vue')
            },
        ]
    }
];

const router = new VueRouter({
    routes: routes,
    mode: 'history',
    linkExactActiveClass: 'active',
    scrollBehavior: (to, from, savedPosition) => {
        return savedPosition || {x: 0, y: 0}
    }
});

export default router;

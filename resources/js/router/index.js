import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        component: import('../components/Home.vue'),
        name: 'home'
    },
    {
        path: '/register',
        component: import('../components/Auth/Register.vue'),
        name: 'register'
    },
    {
        path: '/login',
        component: import('../components/Auth/Login.vue'),
        name: 'login'
    },
    {
        path: '/knife',
        meta: { requiresAuth: true },
        children: [
            {
                path: '',
                component: import('../components/Knife/Index.vue'),
                name: 'knife'
            },
            {
                path: 'store',
                component: import('../components/Knife/Store.vue'),
                name: 'knifeStore'
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem("token");

    if (to.meta.requiresAuth && !isAuthenticated) {
        next({ name: "login" });
    } else if (to.meta.guest && isAuthenticated) {
        next({ name: "home" });
    } else {
        next();
    }
});


export default router;

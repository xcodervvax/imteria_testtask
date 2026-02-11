import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        name: 'login',
        component: () => import('@/components/Login.vue'),
        meta: { guest: true },
    },
];

export const router = createRouter({
    history: createWebHistory(),
    routes,
});
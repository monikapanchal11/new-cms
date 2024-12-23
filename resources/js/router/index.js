import { createRouter, createWebHistory } from 'vue-router';
import PageView from '../views/PageView.vue';
import PageManager from '../views/PageManager.vue';


const routes = [
    {
        path: '/',
        name: 'home',
        component: PageManager, //component rendering pages CRUD
    },
    {
        path: '/:slug(.*)*', 
        name: 'pageview',
        component: PageView, //component render for dynamic page content
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

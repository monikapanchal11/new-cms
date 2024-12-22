import { createRouter, createWebHistory } from 'vue-router';
import PageView from '../views/PageView.vue';
import PageManager from '../views/PageManager.vue';  // CRUD component


const routes = [
    {
        path: '/',
        name: 'home',
        component: PageManager, // Main page manager
    },
    {
        path: '/:slug',
        name: 'pageview',
        component: PageView, // Component to render
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;


// import { createRouter, createWebHistory } from 'vue-router';
// import PageManager from '../views/PageManager.vue';  // CRUD component
// import PageView from '../views/PageView.vue';  // Dynamic content view for a page

// const routes = [
//   {
//     path: '/crud',
//     name: 'crud',
//     component: PageManager,
//   },
//   {
//     path: '/:slug(.*)',  // Capture dynamic slugs
//     name: 'dynamic-page',
//     component: PageView,
//   },
// ];

// const router = createRouter({
//   history: createWebHistory(),
//   routes,
// });

// export default router;

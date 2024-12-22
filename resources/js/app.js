// import './bootstrap';
// import '../css/app.css';

// import { createApp } from 'vue';
// import PageManager from './views/PageManager.vue'; // Import the CRUD component

// const app = createApp(PageManager);
// app.mount('#app');


import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Import the router

const app = createApp(App);
app.use(router); // Use the router in the Vue app
app.mount('#app');




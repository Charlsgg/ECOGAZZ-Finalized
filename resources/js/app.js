import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import Login from './authpages/Login.vue';

// 1. Define at least one route so the router doesn't crash
const routes = [
    { path: '/login', component: Login, name: 'login' }
];

// 2. Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

const app = createApp(Login);

// 3. Tell Vue to use the router
app.use(router);
app.mount('#app');
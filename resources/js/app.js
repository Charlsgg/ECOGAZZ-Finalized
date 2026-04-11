import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import axios from 'axios';

import Login from './authpages/Login.vue';
import AdminDashboard from './pages/AdminDashboard.vue';
import EmployeeDashboard from './pages/EmployeeDashboard.vue';
import App from './app.vue'; 

axios.defaults.baseURL = 'http://127.0.0.1:8000';

// 1. Set Initial Header
const token = localStorage.getItem('auth_token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}
axios.interceptors.response.use(
    res => res,
    err => {
        if (err.response.status === 401) {
            // Public tried to access Auth route
            window.location.href = '/login';
        }
        if (err.response.status === 403) {
            // User tried to access "Other User" route
            alert("Forbidden: Access Denied.");
        }
        return Promise.reject(err);
    }
);

const routes = [
    { path: '/', redirect: '/login' },
    { 
        path: '/login', 
        component: Login, 
        name: 'login'
    },
    { 
        path: '/admin/dashboard', 
        component: AdminDashboard, 
        name: 'admin.dashboard',
        meta: { requiresAuth: true }
    },
    { 
        path: '/employee/dashboard', 
        component: EmployeeDashboard, 
        name: 'employee.dashboard',
        meta: { requiresAuth: true }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// 3. Simple Navigation Guard
router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem('auth_token');

    // Only prevent entry to protected pages if not logged in
    if (to.meta.requiresAuth && !isAuthenticated) {
        return next({ name: 'login' });
    }

    next();
});

const app = createApp(App);
app.use(router);
app.mount('#app');
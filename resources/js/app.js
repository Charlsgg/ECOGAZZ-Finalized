import './bootstrap';
import { createApp } from 'vue'; // <-- THIS IS THE CRUCIAL LINE
import axios from 'axios';

import Login from './authpages/Login.vue';
import AdminDashboard from './pages/AdminDashboard.vue';
import EmployeeDashboard from './pages/EmployeeDashboard.vue';
const app = createApp({});


app.component('login-page', Login);

app.mount('#app');
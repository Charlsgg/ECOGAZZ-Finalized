<template>
  <div>
    <h1>Admin Dashboard</h1>
    <button @click="handleLogout" class="bg-red-500 text-white p-2 rounded">
      Logout
    </button>
  </div>
</template>

<script setup>
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const handleLogout = async () => {
    try {
        // 1. Tell Laravel to revoke the token
        await axios.post('/api/logout');
    } catch (error) {
        console.error("Logout failed", error);
    } finally {
        // 2. ALWAYS clear local storage regardless of API success
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user_role');
        
        // 3. Remove the header from axios
        delete axios.defaults.headers.common['Authorization'];

        // 4. Send user back to login
        router.push({ name: 'login' });
    }
};
</script>
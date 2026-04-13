<template>
  <div
    class="fixed inset-0 bg-linear-to-br from-[#1a1c1b] via-[#2d4a3e] to-[#1a1c1b] flex justify-center items-center z-[9000] p-5">
    <div
      class="absolute inset-0 bg-[radial-gradient(circle_at_30%_40%,rgba(61,187,145,0.15)_0%,transparent_60%),radial-gradient(circle_at_70%_70%,rgba(91,124,250,0.1)_0%,transparent_50%)]">
    </div>

    <div
      class="bg-white/95 backdrop-blur-xl py-10 px-9 rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.2)] text-center w-full max-w-95 relative z-10 animate-[scaleIn_0.5s_ease-out]">
      <div
        class="w-17.5 h-17.5 bg-linear-to-br from-[#3dbb91] to-[#2d9e7a] rounded-[20px] flex items-center justify-center mx-auto mb-4 shadow-[0_8px_25px_rgba(61,187,145,0.3)]">
        <i class="fa-solid fa-gas-pump text-[1.8rem] text-white"></i>
      </div>

      <h1 class="text-[1.4rem] font-extrabold tracking-[-0.5px] text-[#1a1c1b] mb-1">EcoGazz GSMS</h1>
      <div class="text-gray-500 text-[0.78rem] font-medium mb-7">Station Login Portal</div>

      <input type="email" v-model="email" placeholder="Email Address" :disabled="isLoggingIn"
        class="w-full p-3.5 mb-3 border-2 border-[#e8ebe9] rounded-xl text-[0.95rem] text-center font-medium bg-[#fafbfa] transition-all focus:outline-none focus:border-[#3dbb91] focus:bg-white">

      <input type="password" v-model="password" placeholder="Password"
        @keydown.enter="attemptLogin(activeBtn || 'Admin')" :disabled="isLoggingIn"
        class="w-full p-3.5 mb-6 border-2 border-[#e8ebe9] rounded-xl text-[0.95rem] text-center tracking-widest font-bold bg-[#fafbfa] transition-all focus:outline-none focus:border-[#3dbb91] focus:bg-white focus:ring-4 focus:ring-[#3dbb91]/15">

      <div class="flex gap-2.5">
        <button @click="attemptLogin('Admin')" :disabled="isLoggingIn"
          class="flex-1 p-3.5 rounded-xl text-[0.85rem] font-bold flex justify-center items-center gap-2 transition-all hover:-translate-y-0.5 shadow-md bg-[#1a1c1b] text-white active:translate-y-0 disabled:opacity-70">
          <i class="fa-solid fa-shield-halved" :class="{ 'fa-spin': isLoggingIn && activeBtn === 'Admin' }"></i> Admin
        </button>

        <button @click="attemptLogin('Employee')" :disabled="isLoggingIn"
          class="flex-1 p-3.5 rounded-xl text-[0.85rem] font-bold flex justify-center items-center gap-2 transition-all hover:-translate-y-0.5 shadow-md bg-linear-to-br from-[#3dbb91] to-[#2d9e7a] text-white active:translate-y-0 disabled:opacity-70">
          <i class="fa-solid fa-user" :class="{ 'fa-spin': isLoggingIn && activeBtn === 'Employee' }"></i> Gasman
        </button>
      </div>

      <transition name="fade">
        <p v-if="errorMessage" class="mt-4 text-red-500 text-xs font-bold">{{ errorMessage }}</p>
      </transition>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
// 1. REMOVED the 'vue-router' import

const email = ref('');
const password = ref('');
const isLoggingIn = ref(false);
const activeBtn = ref(null);
const errorMessage = ref('');
// 2. REMOVED the 'const router = useRouter()' initialization

const attemptLogin = async (intendedRole) => {
  if (!email.value || !password.value) {
    errorMessage.value = "Credentials required.";
    return;
  }

  try {
    errorMessage.value = '';
    isLoggingIn.value = true;
    activeBtn.value = intendedRole;

    const response = await axios.post('/login', {
      email: email.value,
      password: password.value,
      role: intendedRole
    });

    const { token, role, user } = response.data;

    localStorage.setItem('auth_token', token);
    localStorage.setItem('user_role', role);
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

    const normalized = role.toLowerCase().trim();
    console.log("1. The normalized role is:", normalized); // <--- ADD THIS

    if (normalized === 'admin') {
      console.log("2. Attempting Admin Redirect!"); // <--- ADD THIS
      window.location.href = '/admin/dashboard'; 
    } else if (normalized === 'employee') {
      console.log("2. Attempting Employee Redirect!"); // <--- ADD THIS
      window.location.href = '/employee/dashboard'; 
    } else {
      console.log("3. ERROR: Role did not match admin or employee"); // <--- ADD THIS
    }

  } catch (error) {
    // 4. ADDED a console.log so you can see real errors in the DevTools console
    console.error("Login Error:", error); 
    errorMessage.value = (error.response && error.response.data && error.response.data.message) || 'Login failed. Check your connection.';
  } finally {
    isLoggingIn.value = false;
    if (errorMessage.value) activeBtn.value = null;
  }
};
</script>
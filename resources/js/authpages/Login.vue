<template>
    <div class="fixed inset-0 bg-linear-to-br from-[#1a1c1b] via-[#2d4a3e] to-[#1a1c1b] flex justify-center items-center z-[9000] p-5">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_40%,rgba(61,187,145,0.15)_0%,transparent_60%),radial-gradient(circle_at_70%_70%,rgba(91,124,250,0.1)_0%,transparent_50%)]"></div>
        
        <div class="bg-white/95 backdrop-blur-xl py-10 px-9 rounded-3xl shadow-[0_20px_60px_rgba(0,0,0,0.2)] text-center w-full max-w-95 relative z-10 animate-[scaleIn_0.5s_ease-out]">
            
            <div class="w-17.5 h-17.5 bg-linear-to-br from-[#3dbb91] to-[#2d9e7a] rounded-[20px] flex items-center justify-center mx-auto mb-4 shadow-[0_8px_25px_rgba(61,187,145,0.3)]">
                <i class="fa-solid fa-gas-pump text-[1.8rem] text-white"></i>
            </div>
            
            <h1 class="text-[1.4rem] font-extrabold tracking-[-0.5px] text-[#1a1c1b] mb-1">EcoGazz GSMS</h1>
            <div class="text-gray-500 text-[0.78rem] font-medium mb-7">Kimaya Station Management</div>
            
            <input 
                type="password" 
                v-model="pin" 
                placeholder="Enter PIN / Password" 
                @keydown.enter="attemptLogin()"
                :disabled="isLoggingIn"
                class="w-full p-3.5 mb-4 border-2 border-[#e8ebe9] rounded-xl text-[0.95rem] text-center tracking-widest font-bold bg-[#fafbfa] transition-all focus:outline-none focus:border-[#3dbb91] focus:bg-white focus:ring-4 focus:ring-[#3dbb91]/15"
            >
            
            <div class="flex gap-2.5">
                <button 
                    @click="attemptLogin('Manager')" 
                    :disabled="isLoggingIn" 
                    class="flex-1 p-3.5 rounded-xl text-[0.85rem] font-bold flex justify-center items-center gap-2 transition-all hover:-translate-y-0.5 shadow-md bg-[#1a1c1b] text-white active:translate-y-0 disabled:opacity-70"
                >
                    <i class="fa-solid fa-shield-halved" :class="{'fa-spin': isLoggingIn}"></i> Admin
                </button>

                <button 
                    @click="attemptLogin('Staff')" 
                    :disabled="isLoggingIn" 
                    class="flex-1 p-3.5 rounded-xl text-[0.85rem] font-bold flex justify-center items-center gap-2 transition-all hover:-translate-y-0.5 shadow-md bg-linear-to-br from-[#3dbb91] to-[#2d9e7a] text-white active:translate-y-0 disabled:opacity-70"
                >
                    <i class="fa-solid fa-user" :class="{'fa-spin': isLoggingIn}"></i> Gasman
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
import { useRouter } from 'vue-router';

const pin = ref('');
const isLoggingIn = ref(false);
const errorMessage = ref('');
const router = useRouter();

/**
 * @param {string} intendedRole - 'Manager' or 'Staff'
 */
const attemptLogin = async (intendedRole = null) => {
    if (!pin.value) {
        errorMessage.value = "Please enter your PIN.";
        return;
    }

    try {
        errorMessage.value = '';
        isLoggingIn.value = true;

        // Matches your AuthController login method
        const response = await axios.post('/api/login', {
            pin: pin.value,
            intended_role: intendedRole // Passing this helps the UI handle the redirect correctly
        });

        const { token, role, user } = response.data;

        // 1. Perspective Storage
        localStorage.setItem('auth_token', token);
        localStorage.setItem('user_role', role); // This will be 'admin' or 'staff'
        localStorage.setItem('user_name', user.name);
        
        // 2. Set Global Axios Authorization Header
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        // 3. Routing logic based on mapped role from Controller
        if (role === 'admin') {
            router.push({ name: 'admin-dashboard' });
        } else {
            router.push({ name: 'staff-pos' });
        }

    } catch (error) {
        pin.value = '';
        // Handles 401 (Invalid PIN) and 403 (Inactive/Role mismatch)
        errorMessage.value = error.response?.data?.message || 'Unauthorized. Check your credentials.';
    } finally {
        isLoggingIn.value = false;
    }
};
</script>

<style scoped>
@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.92); }
    to { opacity: 1; transform: scale(1); }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
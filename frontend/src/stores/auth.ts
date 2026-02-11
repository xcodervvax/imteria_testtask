import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

import api from '@/lib/axios';
import { useAuthApi } from '@/composables/useAuthApi';

import type { AuthResponse, LoginCredentials, User } from '@/types/auth';

export const useAuthStore = defineStore('auth', () => {
    const token = ref<string | null>(localStorage.getItem('token'));
    const user = ref<User | null>(null);
    const loading = ref(false);
    const error = ref<string | null>(null);

    const isAuthenticated = computed(() => !!token.value);

    const login = async (credentials: LoginCredentials) => {
        loading.value = true;
        error.value = null;

        const authApi = useAuthApi();

        try {
            const data: AuthResponse = await authApi.login(credentials);

            token.value = data.token;
            localStorage.setItem('token', data.token);

            const expiresAt = Date.now() + 30 * 60 * 1000;
            localStorage.setItem('token_expires_at', String(expiresAt));

            api.defaults.headers.common.Authorization = `Bearer ${data.token}`;

            user.value = await authApi.me();
        } catch (e: any) {
            error.value = e?.response?.data?.message ?? 'Ошибка авторизации';
            throw e;
        } finally {
            loading.value = false;
        }
    };

    return {
        token,
        user,
        loading,
        error,
        isAuthenticated,
        login,
    };
});
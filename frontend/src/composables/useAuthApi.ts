import api from '@/lib/axios';
import type { LoginCredentials } from "@/types/auth";

export function useAuthApi() {
    const login = async (credentials: LoginCredentials) => {
        const { data } = await api.post('/login', credentials);
        return data;
    };

    const me = async () => {
        const { data } = await api.get('/me');
        return data;
    };

    const logout = async (): Promise<void> => {
        await api.post('/logout');
    };

    return {
        login,
        logout,
        me,
    };
}

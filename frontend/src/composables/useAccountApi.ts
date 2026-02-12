import { ref } from 'vue';
import api from '@/lib/axios';
import type { AccountResponse, SaveYandexPayload } from "@/types/account";

export const useAccountApi = () => {
    const saveYandex = (payload: SaveYandexPayload) => {
        return api.post('/api/account/yandex', payload)
    }

    const getAccount = () => {
        return api.get<AccountResponse>('/api/account')
    }

    return {
        saveYandex,
        getAccount,
    }
}
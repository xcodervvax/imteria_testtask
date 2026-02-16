import api from '@/lib/axios';
import type { AccountResponse, SaveYandexPayload } from "@/types/account";

export const useAccountApi = () => {
    const saveYandex = (payload: SaveYandexPayload) => {
        return api.post('/account/yandex', payload)
    }

    const getAccount = () => {
        return api.get<AccountResponse>('/account')
    }

    return {
        saveYandex,
        getAccount,
    }
}
import { defineStore } from 'pinia';
import { ref } from 'vue';

import { useAccountApi } from '@/composables/useAccountApi';
import { useUiStore } from '@/stores/ui';

export const useAuthStore = defineStore('auth', () => {
    const yandexMapData = ref<any>(null);

    const fetchYandex = async () => {
        try {
            const authAccount = useAccountApi();
            await authAccount.fetchYandex();
        } catch (e) {
            //
        }
    };

    return {
        yandexMapData,
        fetchYandex,
    };
});
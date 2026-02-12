import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useAccountApi } from '@/composables/useAccountApi';
import { useUiStore } from '@/stores/ui';

export const useAccountStore = defineStore('account', () => {
    const yandexUrl = ref<string | null>(null)
    const rating = ref<number | null>(null)
    const reviewsCount = ref<number | null>(null)
    const error = ref<string | null>(null)

    const api = useAccountApi()
    const uiStore = useUiStore()

    const loadAccount = async () => {
        try {
            uiStore.startLoading()

            const { data } = await api.getAccount()

            yandexUrl.value = data.yandex_url
            rating.value = data.rating
            reviewsCount.value = data.reviews_count
        } catch (e: any) {
            if (e.response?.status !== 404) {
                error.value =
                    e.response?.data?.message || 'Ошибка загрузки аккаунта'
            }
        } finally {
            uiStore.stopLoading()
        }
    }

    const saveYandex = async (url: string) => {
        try {
            uiStore.startLoading()

            await api.saveYandex({ url })

            // после сохранения перезагружаем данные
            await loadAccount()
        } catch (e: any) {
            error.value =
                e.response?.data?.message || 'Ошибка сохранения ссылки'
        } finally {
            uiStore.stopLoading()
        }
    }

    return {
        yandexUrl,
        rating,
        reviewsCount,
        error,
        loadAccount,
        saveYandex,
    }
});

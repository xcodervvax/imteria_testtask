import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useAccountApi } from '@/composables/useAccountApi';
import { useUiStore } from '@/stores/ui';
import { useReviewsStore } from '@/stores/reviews';

export const useAccountStore = defineStore('account', () => {
    const yandexUrl = ref<string | null>(null);
    const rating = ref<number | null>(null);
    const reviewsCount = ref<number | null>(null);
    const error = ref<string | null>(null);
    const organizationName = ref<string | null>(null);
    const userPhone = ref<string | null>(null);

    const api = useAccountApi();
    const uiStore = useUiStore();
    const reviewsStore = useReviewsStore();

    const loadAccount = async () => {
        try {
            uiStore.startLoading();

            const { data } = await api.getAccount();

            // если backend возвращает account + reviews
            const account = data.account ?? data;

            yandexUrl.value = account.yandex_url;
            rating.value = account.rating;
            reviewsCount.value = account.reviews_count;
            organizationName.value = account?.organization_name ?? null;
            userPhone.value = data.user?.phone ?? null;

            if (data.reviews) {
                reviewsStore.setReviews(data.reviews);
            }
        } catch (e: any) {
            if (e.response?.status !== 404) {
                error.value =
                    e.response?.data?.message || 'Ошибка загрузки аккаунта';
            }
        } finally {
            uiStore.stopLoading();
        }
    }

    const saveYandex = async (url: string) => {
        try {
            uiStore.startLoading();
            const startTime = Date.now();
            await api.saveYandex({ url });
            // вычисляем сколько прошло времени
            const elapsed = Date.now() - startTime;

            // если прошло меньше 1 секунды — ждём оставшееся время
            if (elapsed < 1000) {
                await new Promise((resolve) =>
                    setTimeout(resolve, 1000 - elapsed)
                );
            }

            // после сохранения перезагружаем данные
            await loadAccount();
        } catch (e: any) {
            error.value =
                e.response?.data?.message || 'Ошибка сохранения ссылки';
        } finally {
            uiStore.stopLoading();
        }
    }

    return {
        yandexUrl,
        rating,
        reviewsCount,
        error,
        organizationName,
        userPhone,
        loadAccount,
        saveYandex,
    }
});

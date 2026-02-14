import { defineStore } from 'pinia';
import { ref } from 'vue';
import { useReviewsApi } from '@/modules/account/api/useReviewsApi';
import type { Review } from "@/types/review";

export const useReviewsStore = defineStore('reviews', () => {
    const reviews = ref<Review[]>([]);
    const isLoading = ref(false);
    const page = ref(1);
    const total = ref(0);

    const reviewsApi = useReviewsApi();

    async function fetchReviews(reset = false) {
        if (reset) {
            page.value = 1;
            reviews.value = [];
        }

        isLoading.value = true;

        try {
            const response = await reviewsApi.getReviews(page.value);

            reviews.value.push(...response.data.data);
            total.value = response.data.total;

            page.value++;
        } finally {
            isLoading.value = false;
        }
    };

    return {
        reviews,
        isLoading,
        total,
        fetchReviews,
    }
})

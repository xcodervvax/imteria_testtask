import api from '@/lib/axios';

export function useReviewsApi() {
    const getReviews = (page = 1) => {
        return api.get('/reviews', {
            params: { page }
        })
    };

    return {
        getReviews,
    }
};

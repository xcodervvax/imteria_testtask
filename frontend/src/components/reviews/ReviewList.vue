<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import type { Review } from "@/types/review";
const ReviewItem = defineAsyncComponent(() => import('./ReviewItem.vue'));

defineProps<{
  reviews: Review[]
}>();
</script>

<template>
  <div>
    <ReviewItem
        v-for="review in reviews"
        :key="review.id"
        :author="review.author"
        :rating="review.rating"
        :text="review.text"
        :review-date="review.review_date"
    />
  </div>
</template>

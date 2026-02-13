<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
const StarRating = defineAsyncComponent(() => import('./StarRating.vue'));

defineProps<{
  rating: number;
  reviewsCount: number;
}>();
</script>

<template>
  <div class="rating-card">
    <div class="rating-number">
      {{ rating.toFixed(1) }}
    </div>

    <StarRating :rating="rating" />

    <div class="reviews-count">
      Всего отзывов {{ reviewsCount }}
    </div>
  </div>
</template>

<style scoped>
@import '../assets/styles/rating-card.css';
</style>

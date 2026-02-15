<script setup lang="ts">
import { computed, defineAsyncComponent } from 'vue';
const StarRating = defineAsyncComponent(() => import('./StarRating.vue'));

const props = defineProps<{
  rating: number;
  reviewsCount: number;
}>();

const ratingVal = computed(() => props.rating ? props.rating.toFixed(1) : null);
</script>

<template>
  <div class="rating-card">
    <div class="rating-row-1">
      <div class="rating-number">
        {{ ratingVal }}
      </div>

      <StarRating :rating="rating" size="big" />
    </div>

    <hr class="delimeter" />

    <div class="reviews-count">
      Всего отзывов: {{ reviewsCount }}
    </div>
  </div>
</template>

<style scoped>
@import '../../assets/styles/rating-card.css';
</style>

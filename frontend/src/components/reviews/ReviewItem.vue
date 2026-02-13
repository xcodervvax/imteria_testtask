<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
const StarRating = defineAsyncComponent(() => import('../rating/StarRating'));

defineProps<{
  author: string;
  rating: number;
  text: string;
  reviewDate: string;
}>();
</script>

<template>
  <div class="review-item">
    <div class="review-header">
      <div class="author">{{ author }}</div>
      <StarRating :rating="rating" />
    </div>

    <div class="date">
      {{ new Date(reviewDate).toLocaleDateString() }}
    </div>

    <div class="text">
      {{ text }}
    </div>
  </div>
</template>

<style scoped>
@import '../assets/styles/review-item.css';
</style>

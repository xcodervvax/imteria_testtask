<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
const StarRating = defineAsyncComponent(() => import('../rating/StarRating.vue'));
import { formatDate } from '@/utils/formatDate';

defineProps<{
  author: string;
  rating: number;
  text: string;
  reviewDate: string;
}>();

const truncateText = (text: string, maxLength: number) => {
  if (text.length > maxLength) {
    return text.substring(0, maxLength) + '...';
  }
  return text;
};
</script>

<template>
  <div class="review-item">
    <div class="review-header">
      <div class="review-header-left-block">
        <div class="formatted-date">
          {{ formatDate(reviewDate) }}
        </div>

        <img class="ynd-review" src="/images/ymap.png" alt="Яндекс лого" />
      </div>

      <div class="review-header-right-block">
        <StarRating :rating="rating" />
      </div>
    </div>

    <div class="row-1">
      <div class="author">{{ author }}</div>
    </div>

    <div class="row-2">
      <span class="row-2__context">{{ truncateText(text, 550) }}</span>
    </div>
  </div>
</template>

<style scoped>
@import '../../assets/styles/review-item.css';
</style>

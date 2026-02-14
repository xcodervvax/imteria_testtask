<script setup lang="ts">
import { defineAsyncComponent } from 'vue';
import type { Review } from "@/types/review";
const ReviewItem = defineAsyncComponent(() => import('./ReviewItem.vue'));

defineProps<{
  reviews: Review[]
}>();
</script>

<template>
  <div class="review-list-container">
    <div class="map-wrapper">
      <img class="ynd-map" src="/images/ymap.png" alt="Яндекс лого" />
      <span class="map-wrapper__title">Яндекс карты</span>
    </div>

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

<style>
@import '../../assets/styles/review-list.css';
</style>

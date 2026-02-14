<script setup lang="ts">
import { storeToRefs } from 'pinia';
import { defineAsyncComponent } from 'vue';

import { useAccountStore } from '@/stores/account';

const RatingCard = defineAsyncComponent(() => import('./rating/RatingCard.vue'));
const ReviewList = defineAsyncComponent(() => import('./reviews/ReviewList.vue'));

const accountStore = useAccountStore();
const { rating, reviewsCount } = storeToRefs(accountStore);

import { useReviewsStore } from '@/stores/reviews';
const reviewsStore = useReviewsStore();
const { reviews } = storeToRefs(reviewsStore);
</script>

<template>
  <div class="reviews-layout">
    <div class="reviews-left">
      <ReviewList :reviews="reviews" />
    </div>

    <div class="reviews-right" v-if="rating !== null">
      <RatingCard
          :rating="rating"
          :reviewsCount="reviewsCount ?? 0"
      />
    </div>
  </div>
</template>

<style scoped>
@import '../assets/styles/account-reviews.css';
</style>
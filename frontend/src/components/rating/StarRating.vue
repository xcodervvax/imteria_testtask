<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
  rating: number;
  max?: number;
}>();

const maxStars = computed(() => props.max ?? 5);
const fullStars = computed(() => Math.floor(props.rating));
const hasHalfStar = computed(() => props.rating % 1 >= 0.5);
</script>

<template>
  <div class="stars">
    <span
        v-for="n in maxStars"
        :key="n"
        class="star"
        :class="{
        full: n <= fullStars,
        half: n === fullStars + 1 && hasHalfStar
      }"
    >
      ★
    </span>
  </div>
</template>

<style scoped>
@import '../../assets/styles/star-rating.css';
</style>
<script setup lang="ts">
import { defineAsyncComponent } from 'vue';

const AccountPage = defineAsyncComponent(() => import('../components/Account.vue'));
</script>

<template>
<AccountPage />
</template>

<style scoped>
</style>
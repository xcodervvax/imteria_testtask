<script setup lang="ts">
import { defineAsyncComponent } from "vue";
import { useUserRouter } from '@/composables/useUserRouter';
import { useAuthStore } from "@/stores/auth";

const Exit = defineAsyncComponent(() => import('../components/Exit.vue'));

const { goToLogin } = useUserRouter();
const auth = useAuthStore();

const handleLogout = async () => {
  try {
    await auth.logout();
    localStorage.removeItem('token');
    await goToLogin();
  } catch (e) {
    console.error(e);
  }
};
</script>

<template>
  <header class="app-header">
    <el-button class="logout-btn" @click="handleLogout">
      <Exit />
    </el-button>
  </header>
</template>

<style>
@import '../assets/styles/app-header.css';
</style>

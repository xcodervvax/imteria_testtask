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
.app-header {
  height: 60px;
  background: white;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 24px;
}

.logout-btn {
  border: none;
  outline: none;
}

.logout-btn:hover {
  background-color: transparent;
  color: transparent;
}
</style>

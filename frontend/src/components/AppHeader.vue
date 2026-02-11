<script setup lang="ts">
import { useRouter } from 'vue-router';
import { logout } from '@/composables/useAuthApi';

const router = useRouter();

const handleLogout = async () => {
  try {
    await logout();
    localStorage.removeItem('token');
    router.push('/login');
  } catch (e) {
    console.error(e);
  }
};
</script>

<template>
  <header class="app-header">
    <div class="logo">Daily Grow</div>

    <el-button type="danger" @click="handleLogout">
      Выйти
    </el-button>
  </header>
</template>

<style scoped>
.app-header {
  height: 60px;
  background: white;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 24px;
}

.logo {
  font-weight: bold;
  font-size: 16px;
}
</style>

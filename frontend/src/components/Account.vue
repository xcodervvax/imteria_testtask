<script setup lang="ts">
import { defineAsyncComponent } from 'vue';

const AppHeader = defineAsyncComponent(() => import('../components/AppHeader.vue'));
const AccountSettings = defineAsyncComponent(() => import('../components/AccountSettings.vue'));
const Repair = defineAsyncComponent(() => import('../components/Repair.vue'));
</script>

<template>
  <div class="account-layout">
    <div class="account-body">

      <!-- Левый блок -->
      <aside class="sidebar">
        <img src="/images/logo.png" alt="Logo">
        <div class="account-name">
          Название аккаунта
        </div>

        <div class="reviews-container">
          <div class="repair-image">
            <Repair />
          </div>

          <span class="reviews-container__text">Отзывы</span>
        </div>

        <el-menu default-active="settings" class="menu">
          <el-menu-item index="reviews">
            Отзывы
          </el-menu-item>

          <el-menu-item index="settings">
            Настройка
          </el-menu-item>
        </el-menu>
      </aside>

      <!-- Правый блок -->
      <main class="content">
        <AppHeader />
        <AccountSettings />
      </main>

    </div>
  </div>
</template>

<style scoped>
@import '../assets/styles/account.css';
</style>

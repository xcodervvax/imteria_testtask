<script setup lang="ts">
import { computed, defineAsyncComponent, onMounted, ref } from 'vue';

import { useAccountStore } from "@/stores/account";
import {useAuthStore} from "@/stores/auth";

const AppHeader = defineAsyncComponent(() => import('../components/AppHeader.vue'));
const AccountSettings = defineAsyncComponent(() => import('../components/AccountSettings.vue'));
const Repair = defineAsyncComponent(() => import('../components/Repair.vue'));
const AccountReviews = defineAsyncComponent(() => import('../components/AccountReviews.vue'));

type Tab = 'settings' | 'reviews';
const accountStore = useAccountStore();

const activeTab = ref<Tab>('settings');

const currentComponent = computed(() => {
  return activeTab.value === 'settings'
      ? AccountSettings
      : AccountReviews
});

function handleSelect(index: string) {
  activeTab.value = index as Tab;
}

onMounted(() => {
  accountStore.loadAccount();
});
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

        <el-menu default-active="settings"
                 class="menu left-menu"
                 @select="handleSelect">
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

        <Transition>
          <component :is="currentComponent" />
        </Transition>
      </main>

    </div>
  </div>
</template>

<style>
@import '../assets/styles/account.css';
</style>

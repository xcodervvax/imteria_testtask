<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';

const yandexUrl = ref<string>('');
const loading = ref<boolean>(false);

const handleSave = async () => {
  loading.value = true;
  try {
    await axios.post('/api/account/yandex', {
      url: yandexUrl.value
    });
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="settings-wrapper">
    <span class="title">Подключить Яндекс</span>

    <section class="settings-tooltip">
      <span class="settings-tooltip__text">Укажите ссылку на Яндекс, пример</span>
      <span class="settings-tooltip__link">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</span>
    </section>

    <div class="link-wrapper">
      <el-input
          class="ydx-input"
          v-model="yandexUrl"
          placeholder="Вставьте ссылку на Яндекс карточку"
          size="large"
          clearable
      />
    </div>

    <el-button
        type="primary"
        size="large"
        class="save-button"
        @click="handleSave"
        :loading="loading"
    >
      Сохранить
    </el-button>
  </div>
</template>

<style>
@import '../assets/styles/account-settings.css';
</style>

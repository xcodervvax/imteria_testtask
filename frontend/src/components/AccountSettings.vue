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
@import '../assets/styles/style.css';

.settings-wrapper {
  width: 100%;

  display: flex;
  flex-direction: column;
}

.title {
  font-family: Mulish, sans-serif;
  font-size: 16px;
  font-weight: 600;
  line-height: 20px;

  width: 100%;

  display: inline-block;

  margin-bottom: 20px;

  color: var(--color-dark-blue);
  text-align: start;
}

.settings-tooltip {
  display: flex;
  align-items: center;
  justify-content: flex-start;

  margin-bottom: 10px;
}

.settings-tooltip__text {
  font-family: Mulish, sans-serif;
  font-size: 12px;
  font-weight: 600;

  display: inline-block;

  margin-right: 10px;

  color: var(--color-gray1);
}

.settings-tooltip__link {
  font-family: Mulish, sans-serif;
  font-size: 12px;
  font-weight: 400;

  color: var(--color-gray1);
  letter-spacing: 0px;
}

.el-input__inner {
  font-family: Mulish, sans-serif;
  font-size: 12px;
  font-weight: 400;

  height: 26px;

  border-radius: 6px;
  color: var(--color-gray1);
  letter-spacing: 0px;
}

.link-wrapper {
  width: 480px;
}

.save-button {
  margin-top: 16px;
}
</style>

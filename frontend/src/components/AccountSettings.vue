<script setup lang="ts">
import { ref } from 'vue';
import type { FormInstance, FormRules } from 'element-plus';
import axios from 'axios';

interface AccountForm {
  yandexUrl: string
}

const formRef = ref<FormInstance>();

const form = ref<AccountForm>({
  yandexUrl: ''
});

const rules: FormRules<AccountForm> = {
  yandexUrl: [
    { required: true, message: 'Введите ссылку', trigger: 'blur' },
    {
      type: 'url',
      message: 'Введите корректный URL',
      trigger: 'blur'
    },
    {
      validator: (_, value, callback) => {
        if (!value.includes('yandex.ru')) {
          callback(new Error('Ссылка должна вести на yandex.ru'));
        } else {
          callback();
        }
      },
      trigger: 'blur'
    }
  ]
};

const yandexUrl = ref<string>('');
const loading = ref<boolean>(false);

const handleSubmit = async () => {
  if (!formRef.value) return;

  await formRef.value.validate(async (valid) => {
    if (!valid) return;

    loading.value = true;

    try {
      await axios.post('/api/account/yandex', {
        url: form.value.yandexUrl
      });;
    } catch (e) {
      console.error(e)
    } finally {
      loading.value = false;
    }
  })
};
</script>

<template>
  <div class="settings-wrapper">
    <span class="title">Подключить Яндекс</span>

    <section class="settings-tooltip">
      <span class="settings-tooltip__text">Укажите ссылку на Яндекс, пример</span>
      <span class="settings-tooltip__link">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</span>
    </section>

    <el-form
        class="link-wrapper"
        ref="formRef"
        :model="form"
        :rules="rules"
        label-position="top"
    >
      <el-form-item
          label="Ссылка на Яндекс карточку"
          prop="yandexUrl"
      >
        <el-input
            class="ydx-input"
            v-model="form.yandexUrl"
            placeholder="https://yandex.ru/maps/..."
            size="large"
        />
      </el-form-item>

      <el-button
          class="save-button"
          type="primary"
          size="large"
          :loading="loading"
          @click="handleSubmit"
      >
        Сохранить
      </el-button>
    </el-form>
  </div>
</template>

<style>
@import '../assets/styles/account-settings.css';
</style>

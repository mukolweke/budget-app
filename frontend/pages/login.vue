<script lang="ts" setup>
import { useAuthStore } from '~/stores/useAuthStore';

definePageMeta({
  middleware: ['guest']
});

const form = ref({
  email: "test@example.com",
  password: "password",
});

const auth = useAuthStore();

async function handleLogin() {
  if (auth.isLoggedIn) {
    return navigateTo("/")
  };

  const { error } = await auth.login(form.value);

  if (!error.value) {
    return navigateTo("/")
  };
}
</script>

<template>
  <form @submit.prevent="handleLogin">
    <label for="email">
      Email
      <input type="text" v-model="form.email" />
    </label>

    <label>
      Password
      <input type="password" v-model="form.password" />
    </label>

    <button>Login</button>
  </form>
</template>

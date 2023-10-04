<script lang="ts" setup>
import { useAuthStore } from '~/stores/useAuthStore';

definePageMeta({
  middleware: ['guest']
});

const form = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const auth = useAuthStore();

async function handleRegister() {
  if (auth.isLoggedIn) {
    return navigateTo("/")
  };

  const { error } = await auth.register(form.value);

  if (!error.value) {
    return navigateTo("/")
  };

  console.log('register error', error);
}
</script>

<template>
  <form @submit.prevent="handleRegister">
    <label>
      Name
      <input type="text" v-model="form.name" />
    </label>

    <label>
      Email
      <input type="email" v-model="form.email" />
    </label>

    <label>
      Password
      <input type="password" v-model="form.password" />
    </label>

    <label>
      Password Confirmation
      <input type="password" v-model="form.password_confirmation" />
    </label>

    <button>Register</button>
  </form>
</template>

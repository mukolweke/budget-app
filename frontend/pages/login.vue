<script lang="ts" setup>
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
  middleware: ["guest"],
  layout: "guest",
});

const loginForm = ref({
  email: "test@example.com",
  password: "password",
  errors: {
    email: "",
    password: "",
  },
});

let submittingForm = ref(false);

const auth = useAuthStore();

async function handleLogin() {
  submittingForm.value = true;

  if (auth.isLoggedIn) {
    return navigateTo("/");
  }

  const { error } = await auth.login(loginForm.value);
  loginForm.value.errors = error.value?.data.errors;

  submittingForm.value = false;

  if (!error.value) {
    return navigateTo("/");
  }
}
</script>

<template>
  <form @submit.prevent="handleLogin">
    <div class="card w-[500px]">
      <!-- welcome Message -->
      <h2 class="text-2xl text-center font-normal mb-6 text-90">
        Welcome Back!
      </h2>

      <!-- divider -->
      <div class="bg-gray-300 h-px w-24 mx-auto mb-6"></div>

      <!-- Email Input -->
      <div class="mb-4">
        <icon-input
          label="Email Address"
          v-model="loginForm.email"
          id="email"
          placeholder="name@flowbite.com"
          :error="loginForm.errors.email"
        >
          <!-- icon -->
          mail
        </icon-input>
      </div>

      <!-- Password Input -->
      <div class="mb-6">
        <icon-input-password
          label="Password"
          v-model="loginForm.password"
          id="password"
          :error="loginForm.errors.password"
        />
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        class="btn w-full p-3.5 font-bold uppercase tracking-widest mb-6"
        :disabled="submittingForm"
      >
        Login
      </button>

      <!-- Redirect To Register -->
      <p
        class="w-full text-center font-medium text-xs capitalize hover:underline"
      >
        <nuxt-link to="/register">Don't have an account?</nuxt-link>
      </p>
    </div>
  </form>
</template>

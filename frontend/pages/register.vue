<script lang="ts" setup>
import { useAuthStore } from "~/stores/useAuthStore";

definePageMeta({
  middleware: ["guest"],
  layout: "guest",
});

const registerForm = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  errors: {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  },
});

let submittingForm = ref(false);

const auth = useAuthStore();

async function handleRegister() {
  submittingForm.value = true;

  if (auth.isLoggedIn) {
    return navigateTo("/");
  }

  const { error } = await auth.register(registerForm.value);
  registerForm.value.errors = error.value?.data.errors;

  submittingForm.value = false;

  if (!error.value) {
    return navigateTo("/");
  }

  console.log("register error", error);
}
</script>

<template>
  <form @submit.prevent="handleRegister">
    <div class="card w-[500px]">
      <!-- welcome Message -->
      <h2 class="text-2xl text-center font-normal mb-6 text-90">Welcome!</h2>

      <!-- divider -->
      <div class="bg-gray-300 h-px w-24 mx-auto mb-6"></div>

      <!-- Name Input -->
      <div class="mb-4">
        <icon-input
          label="Name"
          v-model="registerForm.name"
          id="name"
          placeholder="John Doe"
          :error="registerForm.errors.name"
        >
          <!-- icon -->
          person
        </icon-input>
      </div>

      <!-- Email Input -->
      <div class="mb-4">
        <icon-input
          label="Email"
          v-model="registerForm.email"
          id="email"
          type-val="email"
          placeholder="name@flowbite.com"
          :error="registerForm.errors.email"
        >
          <!-- icon -->
          mail
        </icon-input>
      </div>

      <!-- Password Input -->
      <div class="mb-6">
        <icon-input-password
          label="Password"
          v-model="registerForm.password"
          id="password"
          :error="registerForm.errors.password"
        />
      </div>

      <!-- Password Confirm Input -->
      <div class="mb-6">
        <icon-input-password
          label="Password Confirm"
          v-model="registerForm.password_confirmation"
          id="password_confirmation"
          :error="registerForm.errors.password_confirmation"
        />
      </div>

      <!-- Submit Button -->
      <button
        type="submit"
        class="btn w-full p-3.5 font-bold uppercase tracking-widest mb-6"
        :disabled="submittingForm"
      >
        Register
      </button>

      <!-- Redirect To Register -->
      <p
        class="w-full text-center font-medium text-xs capitalize hover:underline"
      >
        <nuxt-link to="/login">already registered?</nuxt-link>
      </p>
    </div>
  </form>
</template>

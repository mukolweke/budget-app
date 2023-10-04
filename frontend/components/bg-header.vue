<script setup>
import { useAuthStore } from '~/stores/useAuthStore';

const auth = useAuthStore();

async function handleLogout() {
  await auth.logout();
}
</script>

<template>
  <header class="shadow-sm bg-white">
    <nav class="container mx-auto p-4 flex items-center justify-between">
      <nuxt-link to="/" class="font-bold text-[#12b488] text-2xl flex items-center">
        <span class="material-symbols-outlined text-3xl mr-2">
          credit_score
        </span>

        Budget Buddy
      </nuxt-link>

      <ul class="flex items-center gap-4">
        <li>
          <nuxt-link to="/login">Login</nuxt-link>
        </li>
        <li>
          <nuxt-link to="/register">Register</nuxt-link>
        </li>
        <li>
          <nuxt-link to="/admin">Admin Only</nuxt-link>
        </li>
        <li>
          <button class="btn" v-if="auth.isLoggedIn" @click="handleLogout">Logout</button>
        </li>
      </ul>
    </nav>
  </header>
</template>

<style scoped>
.router-link-active.router-link-exact-active {
  @apply text-[#12b488] font-bold;
}
</style>

<script lang="ts" setup>
import { useAuthStore } from "~/stores/useAuthStore";

const auth = useAuthStore();

async function handleLogout() {
  await auth.logout();
}
</script>

<template>
  <div>
    <bg-header></bg-header>

    <div class="container mx-auto p-4">
      <div class="flex items-start w-full">
        <!-- Sidebar/Menu -->
        <aside class="w-1/4 p-4">
          <!-- Your menu items go here -->
          <ul>
            <li class="mb-6 font-semibold w-full">
              <nuxt-link
                class="p-3 rounded-md transition duration-150 flex items-center"
                to="/"
              >
                <span class="material-symbols-outlined mr-2"> home </span>
                Home
              </nuxt-link>
            </li>
            <li class="mb-6 font-semibold w-full">
              <nuxt-link
                class="p-3 rounded-md transition duration-150 flex items-center"
                to="/income"
              >
                <span class="material-symbols-outlined mr-2">
                  attach_money
                </span>
                Income
              </nuxt-link>
            </li>
            <li class="mb-6 font-semibold w-full">
              <nuxt-link
                class="p-3 rounded-md transition duration-150 flex items-center"
                to="/savings"
              >
                <span class="material-symbols-outlined mr-2"> savings </span>
                Savings
              </nuxt-link>
            </li>
            <li class="mb-6 font-semibold w-full">
              <nuxt-link
                class="p-3 rounded-md transition duration-150 flex items-center"
                to="/expenses"
              >
                <span class="material-symbols-outlined mr-2">
                  shopping_cart_checkout
                </span>
                Expenses
              </nuxt-link>
            </li>
            <li class="mb-6 font-semibold w-full">
              <button
                class="btn w-full text-left text-primary flex items-center p-3 bg-transparent hover:bg-gray-100 focus:text-primary"
                v-if="auth.isLoggedIn"
                @click="handleLogout"
              >
                <span class="material-symbols-outlined mr-2"> logout </span>
                Logout
              </button>
            </li>
          </ul>
        </aside>

        <!-- Content -->
        <main class="w-3/4 p-4">
          <!-- Your content goes here -->
          <slot />
        </main>
      </div>
    </div>
  </div>
</template>

<style scoped>
.router-link-active.router-link-exact-active {
  @apply text-white bg-primary w-full;
}
</style>

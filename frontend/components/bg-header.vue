<script setup lang="ts">
import { useAuthStore } from "~/stores/useAuthStore";

const { balance } = useSummary();

// const { $listen } = useNuxtApp();

// let balance = ref<any>(0);

// $listen("total:balance", (total_balance) => {
//   balance.value = total_balance ?? 0;
// });

const auth = useAuthStore();

async function handleLogout() {
  await auth.logout();
}
</script>

<template>
  <header class="shadow-sm bg-white">
    <nav class="container mx-auto p-4 flex items-center justify-between">
      <nuxt-link
        to="/dash"
        class="font-bold text-[#12b488] text-2xl flex items-center"
      >
        <span class="material-symbols-outlined text-3xl mr-2">
          credit_score
        </span>

        Budget Buddy
      </nuxt-link>

      <ul class="flex items-center">
        <li class="flex items-center mr-2">
          <span class="material-symbols-outlined text-primary mr-2">
            account_balance_wallet
          </span>
          <span class="text-sm">
            Left To Spend:
            <span class="font-bold ml-1 tracking-wider">KES {{ balance }}</span>
          </span>
        </li>
        <li>
          <span
            title="notifications"
            class="hover:text-primary p-2 py-2.5 rounded-full cursor-pointer"
          >
            <span class="material-symbols-outlined"> notifications </span>
          </span>
        </li>
        <li>
          <span
            title="logout"
            class="hover:text-primary p-2 py-2.5 rounded-full cursor-pointer"
            @click="handleLogout"
          >
            <span class="material-symbols-outlined"> logout </span>
          </span>
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

<script setup lang="ts">
const { balance } = useSummary();

// const { $listen } = useNuxtApp();

// let balance = ref<any>(0);

// $listen("total:balance", (total_balance) => {
//   balance.value = total_balance ?? 0;
// });
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

      <ul class="flex items-center gap-4">
        <li class="flex items-center">
          <span class="material-symbols-outlined text-primary mr-2">
            account_balance_wallet
          </span>
          <span class="text-sm">
            Left To Spend:
            <span class="font-bold ml-1 tracking-wider">KES {{ balance }}</span>
          </span>
        </li>
        <li>
          <span class="hover:text-primary p-2.5 rounded-full cursor-pointer">
            <span class="material-symbols-outlined"> notifications </span>
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

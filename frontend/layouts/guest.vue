<script setup>

</script>

<template>
  <div class="grid place-content-center min-h-screen">
    <!-- Logo -->
    <div class="mb-8">
      <nuxt-link
        to="/"
        class="font-bold text-[#12b488] text-3xl flex items-center justify-center"
      >
        <span class="material-symbols-outlined text-4xl mr-2">
          credit_score
        </span>

        Budget Buddy
      </nuxt-link>
    </div>

    <!-- Content -->
    <slot />
  </div>
</template>

